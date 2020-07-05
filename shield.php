<?php session_start();
require_once('activate.php');


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
