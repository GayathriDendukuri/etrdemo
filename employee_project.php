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

include("classes/employeeproject.class.php");

$objMessages = new Messages();
$objEmployeeProjectList = new EmployeeProject();

$moduleLabel = "Employee Project"; 
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
	
	default:
    		/* List the customers  */
			$count = $objEmployeeProjectList->getEmployeeProjectCount($logininfo['employee_id']);
			if($count>0){
				$employeeProjectList = $objEmployeeProjectList->getEmployeeProjectList($logininfo['employee_id']);
			}
            include("layouts/employee_project.html");
               
}
 
?>