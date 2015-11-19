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

	
$projectId = 1;


$date = gmdate("Y-m-d", strtotime("-1 days"));
echo "cron to check for the reports on " . $date . "<br>";

$projectslist = $objProjectWiseDailyCron->getAllAssignedProjectsHavingChecksList();
if(count($projectslist) > 0){
	foreach($projectslist as $project){
		$notReportingEmployeeData = $objProjectWiseDailyCron->getEmployeeNotReported($project['project_id'], $date);
		//$notReportingEmployeeData = $objProjectWiseDailyCron->getEmployeeNotReported($date);
		//print_r($notReportingEmployeeData);exit;
		foreach($notReportingEmployeeData as $data){
			$empInfo = $empObj->getDataById($data['employee_id']);
			$projectInfo = $projectObj->getDataById($data['project_id']);
			//print_r($empInfo); print_r($projectInfo);
			$name = $empInfo['fname'] . " " . $empInfo['lname'];	
			$pName = $projectInfo['name'];
			$subject = SUB_NOT_REPORTING . $date;
			$message = MESSAGE_NOT_REPORTING;			
			$message = str_replace("{NAME}", $name, $message);
			$message = str_replace("{PROJECT}", $pName, $message);
			$message = str_replace("{DATE}", $date, $message);
			if(sendMail($empInfo['email'], FROM_EMAIL, $subject, $message)){
				echo "mail sent --- ";
			}else{
				echo "mail not sent --- ";
			}
			echo $empInfo['email'] . "<br>";
			echo $subject . "<br>";
			echo $message . "<br>---------<br>";
		}
	}
}else{
	echo "No projects to check.";
}
 
?>