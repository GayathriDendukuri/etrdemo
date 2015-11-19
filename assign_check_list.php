<?php
include("includes/header.inc.php");

if($logininfo['admin_type']!="1"){
	header("Location: index.php");
	exit;
}
include("classes/assigncheck.class.php");
include("classes/check.class.php");
include("classes/project.class.php");

$objMessages = new Messages();
$objChekOption = new CheckOption();
$objProject = new Project();
$objAssignCheckList = new AssignCheckList();

$moduleLabel = "Project Check list assignment"; 
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
		$sMsg1 = $objAssignCheckList->assignCheckList($_POST);
	case "Edit":
		if($action == "Edit"){
			$sMsg1 = $objAssignCheckList->updateCheckList($_POST);
		}
		
		if($sMsg1 == 1){
			$sMsg = $objMessages->addupdatesucessIndication($moduleLabel,$action);
			$count = $objAssignCheckList->getassignedCheckListCount();
			if($count>0){
				$assignedCheckList = $objAssignCheckList->getAssignedCheckList();
			}
            include("layouts/assign_check_list.html");
		}else{			
			if($sMsg1 == 0)
			   $sMsg = $objMessages->errorIndication($moduleLabel,$action);
			else if($sMsg1 == 2)
				$sMsg = $objMessages->duplicateIndication($moduleLabel);
			
			if($id != ""){	
				$assignCheckListData = $objAssignCheckList->getDataById($id);
				$assignCheckListArray = explode(",", $assignCheckListData['assigned_chek_list']);
			}
			$count = $objChekOption->getCheckCount();
			if($count>0){
				$checkList = $objChekOption->getAllCheckList();
				$projectList = $objProject->getAllProjectList();
			}
			include("layouts/forms/assign_check_list.html");
		}
		break;
    case "editForm":
	case "addForm":			
		if($id != ""){	
			$assignCheckListData = $objAssignCheckList->getDataById($id);
			$assignCheckListArray = explode(",", $assignCheckListData['assigned_chek_list']);
		}
		$count = $objChekOption->getCheckCount();
		if($count>0){
			$checkList = $objChekOption->getAllCheckList();
			$projectList = $objProject->getAllProjectList();
		}
		include("layouts/forms/assign_check_list.html");
		break;
	case "changeStatus":  	 
	case "delete":
			if($action == "changeStatus"){
				/* Change status*/ 	
				$sMsg1 = $objAssignCheckList->changeStatus($id,$_GET["status"]);    
				if($sMsg1 == 1){
					$sMsg =  $objMessages->changestatusIndication($moduleLabel);
				}else{
					$sMsg = $objMessages->errorIndication($moduleLabel,$action);
				} 
			}else if($action == "delete"){	
				/* Delete record */ 
				$sMsg1 = $objAssignCheckList->delete($id);  
				if($sMsg1 == 1){
					$sMsg =  $objMessages->addupdatesucessIndication($moduleLabel,$action);
				}else{
					$sMsg = $objMessages->errorIndication($moduleLabel,$action);
				} 
			}
	default:
    		/* List the customers  */
			$count = $objAssignCheckList->getassignedCheckListCount();
			if($count>0){
				$assignedCheckList = $objAssignCheckList->getAssignedCheckList();
			}
            include("layouts/assign_check_list.html");
               
}
 
?>