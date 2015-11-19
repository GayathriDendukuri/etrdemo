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

if($logininfo['admin_type'] != "2"){
	header("Location: index.php");
	exit;
}
$empId = $logininfo['employee_id'];

include("classes/employeeproject.class.php");

$objMessages = new Messages();
$objEmployeeProject = new EmployeeProject();

$moduleLabel = "Project Reporting"; 
$searchstring = ""; $sMsg = "";
$start_limit = 0;

@$page = (isset($_GET['page'])) ? $_GET['page'] : $_POST['page'];

if(!isset($page))
    $page = 1;    
if($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);
	
@$action =  (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$id =  (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];
$projectName = $objEmployeeProject->getProjectNameById($id);

switch($action){	
	case "Add":
	case "Edit":		
		/* Add and update customers */ 						
		$sMsg1 = $objEmployeeProject->addReporting($_POST);
		
		if(@$sMsg1 == 1){
			$sMsg = $objMessages->addupdatesucessIndication($moduleLabel,$action);
			
		}else{			
			if($sMsg1 == 0)
			   $sMsg = $objMessages->errorIndication($moduleLabel,$action);
			else if($sMsg1 == 2)
				$sMsg = $objMessages->duplicateIndication($moduleLabel);
		}
		
	default:
    		/* List the customers  */
			 $checkList = $objEmployeeProject->getEmployeeProjectDataByProjectId($id);$projectCheckOptionsData = $objEmployeeProject->getEmployeeProjectCheckOptionsData($checkList);
			 $projectCheckOptionsDataJson = $objEmployeeProject->getEmployeeProjectCheckOptionsDataInJson($projectCheckOptionsData);
			 //echo $projectCheckOptionsDataJson;exit;
            include("layouts/employee_project_checklist.html");
               
}
 
?>