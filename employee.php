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

include("classes/employee.class.php");
$objMessages = new Messages();
$objEmployee = new EMPLOYEE();

$moduleLabel = "Employee"; 
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
		$sMsg1 = $objEmployee->addEmployee($_POST);
	case "Edit":
		if($action == "Edit"){
			$sMsg1 = $objEmployee->updateEmployee($_POST);
		}
		
		if($sMsg1 == 1){
			$sMsg = $objMessages->addupdatesucessIndication($moduleLabel,$action);
			$count = $objEmployee->getEmployeeCount();
			if($count>0){
				$employeeList = $objEmployee->getEmployeeList();
			}
            include("layouts/employee.html");  
		}else{			
			if($sMsg1 == 0)
			   $sMsg = $objMessages->errorIndication($moduleLabel,$action);
			else if($sMsg1 == 2)
				$sMsg = $objMessages->duplicateIndication($moduleLabel);	
			
			if($id != "")					
				$employeeData = $objEmployee->getDataById($id);			
						
			include("layouts/forms/employee.html");
		}
		break;
    case "editForm":
	case "addForm":
		if($id != ""){	
			$employeeData = $objEmployee->getDataById($id);
		}
		include("layouts/forms/employee.html");
		break;
	case "changeStatus":  	 
	case "delete":
			if($action == "changeStatus"){
				/* Change status*/ 	
				$sMsg1 = $objEmployee->changeStatus($id,$_GET["status"]);    
				if($sMsg1 == 1){
					$sMsg =  $objMessages->changestatusIndication($moduleLabel);
				}else{
					$sMsg = $objMessages->errorIndication($moduleLabel,$action);
				} 
			}else if($action == "delete"){	
				/* Delete record */ 
				$sMsg1 = $objEmployee->delete($id);  
				if($sMsg1 == 1){
					$sMsg =  $objMessages->addupdatesucessIndication($moduleLabel,$action);
				}else{
					$sMsg = $objMessages->errorIndication($moduleLabel,$action);
				} 
			}
	default:
    		/* List the customers  */
			$count = $objEmployee->getEmployeeCount();
			if($count>0){
				$employeeList = $objEmployee->getEmployeeList();
			}
            include("layouts/employee.html");
               
}
 
?>