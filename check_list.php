<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 22/01/2014                                      *
 * Created By : Gayathri                                          *
 * Vision : IB Innovation                                         *
 * Modified by : Gayathri     Date : 22/01/2014    Version : V1   *
 * Description : page management for admin                        *
 *****************************************************************/
 
include("includes/header.inc.php");

if($logininfo['admin_type']!="1"){
	header("Location: index.php");
	exit;
}

include("classes/check.class.php");
$objMessages = new Messages();
$objCity = new CheckOption();

$moduleLabel = "CheckOption"; 
$searchstring = ""; $sMsg = "";
$start_limit = 0;

@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];

if(!isset($page))
    $page = 1;    
if($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);
	
@$action =  (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$id =  (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];

switch($action){	
	case "Add":
		$sMsg1 = $objCity->addCheckOption($_POST);
	case "Edit":
		if($action == "Edit"){
			$sMsg1 = $objCity->updateCheckOption($_POST);
		}
		if($sMsg1 == 1){
			$sMsg = $objMessages->addupdatesucessIndication($moduleLabel,$action);
			$count = $objCity->getCheckCount();
			if($count>0){
				$cityList = $objCity->getCheckList();
			}
            include("layouts/check_list.html");  
		}else{			
			if($sMsg1 == 0)
			   $sMsg = $objMessages->errorIndication($moduleLabel,$action);
			else if($sMsg1 == 2)
				$sMsg = $objMessages->duplicateIndication($moduleLabel);	
			
			if($id != ""){	
				$checkListData = $objCity->getDataById($id);
			}			
			include("layouts/forms/check_list.html");
		}
		break;
    case "editForm":
	case "addForm": 
		if($id != ""){	
			$checkListData = $objCity->getDataById($id);
		}
		include("layouts/forms/check_list.html");
		break;
	case "changeStatus":  	 
	case "delete":
			if($action == "changeStatus"){
				/* Change status*/ 	
				$sMsg1 = $objCity->changeStatus($id,$_GET["status"]);    
				if($sMsg1 == 1){
					$sMsg =  $objMessages->changestatusIndication($moduleLabel);
				}else{
					$sMsg = $objMessages->errorIndication($moduleLabel,$action);
				} 
			}else if($action == "delete"){	
				/* Delete record */ 
				$sMsg1 = $objCity->delete($id);  
				if($sMsg1 == 1){
					$sMsg =  $objMessages->addupdatesucessIndication($moduleLabel,$action);
				}else{
					$sMsg = $objMessages->errorIndication($moduleLabel,$action);
				} 
			}
	default:
    		/* List the customers  */
			$count = $objCity->getCheckCount();
			if($count>0){
				$cityList = $objCity->getCheckList();
			}
            include("layouts/check_list.html");
               
}
 
?>