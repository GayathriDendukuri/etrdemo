<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 20/02/2014                                      *
 * Created By : Pradeep G                                         *
 * Vision : Project Taxreceipt - 2013                             *
 * Modified by : Pradeep G     Date : 20/02/2014    Version : V1  *
 * Description : List donation page                               *
 *****************************************************************/
//date_default_timezone_set("Asia/Kolkata"); 

include ("includes/header.inc.php");
include ("classes/dashboard.class.php");

$Objdashboard = new Dashboard();
$cityList = $Objdashboard->getCityList();
$boxCount = 0;

$dStatus = $Objdashboard->getDeviceStatus();

$ajxRes1 = array(); $ajxRes2 = array();

if(count($cityList) > 0){ 	
	foreach($cityList as $cityData){
		$cityDeviceStatus = $Objdashboard->getDeviceCityStatus($cityData['id']);
		$castatus = explode("/",$cityDeviceStatus);
		if($castatus[1] > 0){
		
			$ajxRes2[] = $cityData['id'].",".$cityDeviceStatus;

			$areaList = $Objdashboard->getAreaList($cityData['id']);
			foreach($areaList as $areaData){
				$deviceList = $Objdashboard->getDeviceList($cityData['id'],$areaData['id']);

				foreach($deviceList as $deviceData){

					$videoData = $Objdashboard->getLiveVideo($deviceData['name']);		
					$vD = ($videoData["video_type"] == 1) ? basename($videoData["video_name"]) : "Live";

					$nowShow = "<a href='javascript:;' class='tooltip'>".$videoData["video_name"]."<span>
											<strong>".$videoData["video_name"]."</strong></span>
											</a>";

					$now = strtotime(date("Y-m-d H:i:s"));
					//echo $deviceData['updated_datetime']."<br>";
					$lastUpdatetime = strtotime($deviceData['updated_datetime']);
					//echo $now.' - '.$lastUpdatetime;
					//echo '<br>'.($now - $lastUpdatetime);
					//exit;
					if(($now - $lastUpdatetime) > 180){
						$Objdashboard->updateInactive($deviceData['name']);
						$deviceData['status'] = 3;
					}

					$boxCount++;		
					//$deviceData['status'] = 1;
					$status = $statusTextArray[$deviceData['status']];
					$ajxRes1[] = $deviceData['name'].",".$deviceData['status'].",".$status.",".$nowShow;
				}
			}
		}
	}
}

if($boxCount != $_GET['boxcount']){
	echo "1";
}else{
	echo json_encode($ajxRes1).":::".json_encode($ajxRes2).":::".$dStatus;
}
exit;			
?>
