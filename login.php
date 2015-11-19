<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 20/02/2014                                      *
 * Created By : Pradeep G                                         *
 * Vision : IB Innovation                                         *
 * Modified by : Pradeep G     Date : 09/06/2014    Version : V1  *
 * Description : Login page                                       *
 *****************************************************************/

include('includes/header.inc.php');

if(isset($_SESSION['ooh_logininfo'])){
    header("Location: index.php");
    exit;
}

include("classes/login_class.php");
$oLogin = new Login();

/* Values from the form*/
@$action = (isset($_GET['action'])) ? trim($_GET['action']) : trim($_POST['action']);
$sMsg = "&nbsp;";

switch($action){
	case "login":	
		$username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
		$password = trim(filter_input(INPUT_POST, 'userpass', FILTER_SANITIZE_STRING));
		$result = $oLogin->authendication($username,$password);
		if(count($result)>1){			
			$loingData["id"] = $result["id"];
			//$loingData["username"] = $result["username"];
			$loingData["username"] = $result["email"];
			$loingData["email"] = $result["email"];
			$loingData["admin_type"] = @$result["admin_type"];
			$loingData["employee_id"] = $result["employee_id"];
			
			if($result["active_status"] == "1"){			
				$userInfo = serialize($loingData);
				$_SESSION['ooh_logininfo'] = $userInfo;
				if($loingData["admin_type"] == "1")
					header("Location:project.php");
				else
					header("Location:employee_project.php");
				exit;
			}else{
				$sMsg = "User blocked. Contact Admin";
				include("layouts/login.html");
			}
		}else{
			$sMsg = "Login Failed, Please Try Again";
			include("layouts/login.html");
		}
	    break;
	default:
		/* Display the login form*/
		include("layouts/login.html");
	    break;
}

?>
