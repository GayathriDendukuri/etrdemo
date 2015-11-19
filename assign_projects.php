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

include("classes/assign_projects.class.php");
$objMessages = new Messages();
$objAssignProject = new Assign_Projects();

$moduleLabel = "Project Assignment"; 
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
		$sMsg1 = $objAssignProject->addAssignProject($_POST);
	case "Edit":
		if($action == "Edit"){
			$sMsg1 = $objAssignProject->updateAssignProject($_POST);
		}
		
		if($sMsg1 == 1){
			$sMsg = $objMessages->addupdatesucessIndication($moduleLabel,$action);
			$count = $objAssignProject->getEmployeeProjectsCount();
			if($count>0){
				$employeeList = $objAssignProject->getEmployeeProjectsList();
			}
            include("layouts/assign_projects.html");  
		}else{			
			if($sMsg1 == 0)
			   $sMsg = $objMessages->errorIndication($moduleLabel,$action);
			else if($sMsg1 == 2)
				$sMsg = $objMessages->duplicateIndication($moduleLabel);	
			
			if($id != "")					
				$employeeProjectData = $objAssignProject->getDataById($id);			
			
			$projectList = $objAssignProject->getAllProjectListHavingChecklist();
			$employeeList = $objAssignProject->getAllEmployeeList();
			include("layouts/forms/assign_projects.html");
		}
		break;
    case "editForm":
	case "addForm":
		if($id != ""){	
			$employeeProjectData = $objAssignProject->getDataById($id);
		}
		//print_r($employeeProjectData);exit;
		$projectList = $objAssignProject->getAllProjectListHavingChecklist();
		$employeeList = $objAssignProject->getAllEmployeeList();
		include("layouts/forms/assign_projects.html");
		break;
	case "changeStatus":  	 
	case "delete":
			if($action == "changeStatus"){
				/* Change status*/ 	
				$sMsg1 = $objAssignProject->changeStatus($id,$_GET["status"]);    
				if($sMsg1 == 1){
					$sMsg =  $objMessages->changestatusIndication($moduleLabel);
				}else{
					$sMsg = $objMessages->errorIndication($moduleLabel,$action);
				} 
			}else if($action == "delete"){	
				/* Delete record */ 
				$sMsg1 = $objAssignProject->delete($id);  
				if($sMsg1 == 1){
					$sMsg =  $objMessages->addupdatesucessIndication($moduleLabel,$action);
				}else{
					$sMsg = $objMessages->errorIndication($moduleLabel,$action);
				} 
			}
	default:
    		/* List the customers  */
			$count = $objAssignProject->getEmployeeProjectsCount();
			if($count>0){
				$employeeList = $objAssignProject->getEmployeeProjectsList();
			}
            include("layouts/assign_projects.html");
               
}
 
?>