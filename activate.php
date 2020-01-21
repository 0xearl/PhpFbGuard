<?php
session_start();
/***************************************************
 * 	    Made With Love By #SABALOFAMILYGC      *
 *                 YAWA KA DABID                   *
 *                  YAWA KA LORD                   *
 *                                                 *
 *                                                 *
 ***************************************************/
class tokenize
{
	private $username;
	private $password;
	function __construct($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
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
		if(strpos($res, 'error') == true){
			throw new Exception('Error!');
		}else{
			return json_decode($res, true);
		}
	}
}
class activate extends tokenize
{
	function __construct($username, $password, $active=null)
	{
		parent::__construct($username,$password);
		$this->active = $active;

	}
	function data()
	{
		return 'variables={"0":{"is_shielded":'.$this->active.',"session_id":"9b78191c-84fd-4ab6-b0aa-19b39f04a6bc","actor_id":'.parent::token()['uid'].',"client_mutation_id":"b0316dd6-3fd6-4beb-aed4-bb29c5dc64b0"}}&method=post&doc_id=1477043292367183&query_name=IsShieldedSetMutation&strip_defaults=true&strip_nulls=true&locale=en_US&client_country_code=US&fb_api_req_friendly_name=IsShieldedSetMutation&fb_api_caller_class=IsShieldedSetMutation';
	}
	function headers()
	{
		$header = array('Content-Type: application/x-www-form-urlencoded', 'Authorization: OAuth '.parent::token()['access_token'].'');
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

		$arr = json_decode($resp, true);

		if($this->active === "true")
		{
			$_SESSION['msg'] = "<div class=\"alert alert-success\" role=\"alert\"><strong>Congratulations!</strong> Profile Guard Has Been Enabled!.</div>";		
		}elseif($this->active === "false"){
			$_SESSION['msg'] = "<div class=\"alert alert-success\" role=\"alert\"><strong>Congratulations!</strong> Profile Guard Has Been Disabled!.</div> ";
		}else{
			$_SESSION['msg'] = "<div class=\"alert alert-danger\" role=\"alert\"><strong>Error!</strong>Error Please Try Again.</div>";
		}
	}
}
if(isset($_POST['submit']))
{
	$errors = ini_get('display_errors');
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
				$t = new tokenize($username, $password);
				$a =  new activate($username, $password, $active);
				$t->generate();
				$a->request();

				header("Location: index.php");
			}catch(Exception $e){
				$_SESSION['msg'] = "<div class=\"alert alert-danger\" role=\"alert\"><strong>Error!</strong> Please Check Your Username Or Password And Try Again.</div>";
				header("Location: index.php");
			}
		}
	}
}

?>
