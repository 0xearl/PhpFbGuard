<?php
session_start();
class FbShield
{
    protected $username;
    protected $password;
    
    function __construct($username, $password, $active){
        $this->username = $username;
        $this->password = $password;
        $this->active = $active;
    }

    function token(){
        return $this->generate();
    }

    function generate(){
        $curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_URL, 'https://b-api.facebook.com/method/auth.login?access_token=237759909591655%25257C0f140aabedfb65ac27a739ed1a2263b1&format=json&sdk_version=2&email='.$this->username.'&locale=en_US&password='.$this->password.'&sdk=ios&generate_session_cookies=1&sig=3f555f99fb61fcd7aa0c44f58f522ef6');
		$res = curl_exec($curl);
		curl_close($curl);
		$arr = json_decode($res, true);
		if(strpos($res, 'error')){
			throw new Exception('Please Check Your Username and Password!');
		}else{
			return json_decode($res, true);
		}
    }
    function data(){
        return 'variables={"0":{"is_shielded":'.$this->active.',"session_id":"9b78191c-84fd-4ab6-b0aa-19b39f04a6bc","actor_id":'.$this->token()['uid'].',"client_mutation_id":"b0316dd6-3fd6-4beb-aed4-bb29c5dc64b0"}}&method=post&doc_id=1477043292367183&query_name=IsShieldedSetMutation&strip_defaults=true&strip_nulls=true&locale=en_US&client_country_code=US&fb_api_req_friendly_name=IsShieldedSetMutation&fb_api_caller_class=IsShieldedSetMutation';
    }
    function headers()
	{
		$header = array('Content-Type: application/x-www-form-urlencoded', 'Authorization: OAuth '.$this->token()['access_token'].'');
		return $header;
    }
    function request()
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://graph.facebook.com/graphql');
		curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers());
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $this->data());
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$resp = curl_exec($curl);
		curl_close($curl);

		return ($this->active === "true") ? $_SESSION['msg'] = "<div class=\"alert alert-success\" role=\"alert\"><strong>Congratulations!</strong> Profile Guard Has Been Enabled!.</div>" : $_SESSION['msg'] = "<div class=\"alert alert-success\" role=\"alert\"><strong>Congratulations!</strong> Profile Guard Has Been Disabled!.</div> ";
		if(!$curl){
			throw new Exception('Unknown error occured, Please Try Again.');
		}
	}
}
if(isset($_POST['submit']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	$active = $_POST['active'];

	if(empty($username)){
		$_SESSION['msg'] = "<div class=\"alert alert-danger\" role=\"alert\"><strong>Error!</strong> Please Check Your Username Or Password And Try Again.</div>";
		header("Location: index.php");
	}else{
		if (empty($password)) {
			$_SESSION['msg'] = "<div class=\"alert alert-danger\" role=\"alert\"><strong>Error!</strong> Please Check Your Username Or Password And Try Again.</div>";
			header("Location: index.php");
		}else{
			try {
                $activateSheild = new FbShield($username, $password, $active);
                $activateSheild->request();

				header("Location: index.php");
			}catch(Exception $e){
				$_SESSION['msg'] = "<div class=\"alert alert-danger\" role=\"alert\"><strong>Error!</strong> {$e->getMessage()} </div>";
				header("Location: index.php");
			}
		}
	}
}

?>
