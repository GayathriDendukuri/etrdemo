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

include("classes/project.class.php");
$objMessages = new Messages();
$objProject = new Project();

$moduleLabel = "Project"; 
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
		$sMsg1 = $objProject->addProject($_POST);
	case "Edit":
		if($action == "Edit"){
			$sMsg1 = $objProject->updateProject($_POST);
		}
		
		if($sMsg1 == 1){
			$sMsg = $objMessages->addupdatesucessIndication($moduleLabel,$action);
			$count = $objProject->getProjectCount();
			if($count>0){
				$projectList = $objProject->getProjectList();
			}
            include("layouts/project.html");  
		}else{			
			if($sMsg1 == 0)
			   $sMsg = $objMessages->errorIndication($moduleLabel,$action);
			else if($sMsg1 == 2)
				$sMsg = $objMessages->duplicateIndication($moduleLabel);	
			
			if($id != "")					
				$projectData = $objProject->getDataById($id);			
						
			include("layouts/forms/project.html");
		}
		break;
    case "editForm":
	case "addForm":
		if($id != ""){	
			$projectData = $objProject->getDataById($id);
		}
		include("layouts/forms/project.html");
		break;
	case "changeStatus":  	 
	case "delete":
			if($action == "changeStatus"){
				/* Change status*/ 	
				$sMsg1 = $objProject->changeStatus($id,$_GET["status"]);    
				if($sMsg1 == 1){
					$sMsg =  $objMessages->changestatusIndication($moduleLabel);
				}else{
					$sMsg = $objMessages->errorIndication($moduleLabel,$action);
				} 
			}else if($action == "delete"){	
				/* Delete record */ 
				$sMsg1 = $objProject->delete($id);  
				if($sMsg1 == 1){
					$sMsg =  $objMessages->addupdatesucessIndication($moduleLabel,$action);
				}else{
					$sMsg = $objMessages->errorIndication($moduleLabel,$action);
				} 
			}
	default:
    		/* List the customers  */
			$count = $objProject->getProjectCount();
			if($count>0){
				$projectList = $objProject->getProjectList();
			}
            include("layouts/project.html");
               
}
 
?>