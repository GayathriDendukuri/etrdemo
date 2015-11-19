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
 // error_reporting(-1);
//ini_set('display_errors', 'On');
include("includes/header.inc.php");

if($logininfo['admin_type']!="1"){
	header("Location: index.php");
	exit;
}
include("classes/project_wise_daily_cron.class.php");
include("classes/project.class.php");
include("classes/employee.class.php");

$empObj = new Employee();
$projectObj = new Project();

$objMessages = new Messages();
$objProjectWiseDailyCron = new PROJECT_WISE_DAILY_CRON();

$moduleLabel = "DailyCron"; 

$date = gmdate("Y-m-d", strtotime("-1 days"));
echo "cron to check for the reports on " . $date . "<br>";
$subject = SUB_NOT_REPORTING_MAIL;
$message = "";
$projectslist = $objProjectWiseDailyCron->getAllAssignedProjectsHavingChecksList();
//print_r($projectslist);exit;
if(count($projectslist) > 0){	
	foreach($projectslist as $project){
		$notReportingEmployeeData = $objProjectWiseDailyCron->getEmployeeNotReported($project['project_id'], $date);
		if(count($notReportingEmployeeData) > 0){
			$projectInfo = $projectObj->getDataById($project['project_id']);
			$pName = $projectInfo['name'];
			$message .= "<tr><td>";
			$message .= $pName . "</td><td>";
			foreach($notReportingEmployeeData as $data){
				$empInfo = $empObj->getDataById($data['employee_id']);
				$name = $empInfo['fname'] . " " . $empInfo['lname'];	
				$message .= $name . "<br>";
			}
			$message .= "</td></tr>";
		}		
	}
	if($message != ""){
		$message = "<table><tr><td>PROJECT</td><td>Employees</td></tr>" . $message . "</table>";
		$mailIds = MAILIDS_TO_GET_NOT_REPORTING_MAIL;
		$mailIdsArray = explode(",", $mailIds);
		foreach($mailIdsArray as $mailId){
			if(sendMail($mailId, FROM_EMAIL, $subject, $message)){
				//echo "mail sent --- ";
			} else{
				//echo "mail not sent --- ";
			}
		}	
	}
}else{
	echo $message = "No projects to check.";
}
 
?>