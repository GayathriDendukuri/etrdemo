<?php 

/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 22/01/2014                                      *
 * Created By : Pradeep G                                         *
 * Vision : Project Sparkle                                       *  
 * Modified by : Pradeep G     Date : 05/02/2014    Version : V1  *
 * Description : Application config file                          *
 *****************************************************************/


/* Define Meta informations  */
define("VERSION", "V 2.0");

define("APPNAME","ETR");
define("ROW_PER_PAGE","10");
define("CLIENT_INFO", "deviceinfo");
define("CLIENT_CHANNEL_HISTORY", "streaminglog");
define("CUSTOMER_INFO", "customerinfo");
define("OCTOSHAPE_CHANNEL_HISTORY", "channelinfo");
define("CUSTOMER_REGISTRATION", "customer_reg");

define("SITENAME", "Ib Streaming");
define("EMPLOYEE_ADMIN_TYPE", "2");

$statusTextArray = array("1" => "Active","2" => "Hold","3" => "In Active");

$commandArray = array("1" => "News","2" => "Live link","3" => "Vod name","4" => "Restart");

define("SMS_GOOGLE_API_KEY", "AIzaSyAj9e4aQ2da3zr92BiSCP4NsQAD3tDg_sQ");

define("SMS_KEY", "14135c6k7z832796cv9s");
define("SMS_SENDER", "QEZYTV");

define("FROM_EMAIL", "ertadmin@ideabytes.in");
define("TO_MAIL", "admin@ideabytes.in");
define("MAILIDS_TO_GET_NOT_REPORTING_MAIL", "gayathri.dendukuri@ideabytes.com");
define("SUB_NOT_REPORTING_MAIL", APPNAME . " || NOT REPORTING EMPLOYEE DETAILS");
define("SUB_USER_ADD", APPNAME);
define("MESSAGE_USER_ADD","Hi {NAME},<br><br>You are added as employee in the " . APPNAME . " <br>Your login details are:<br /> Username : {USERNAME} <br>Password : {NEW_PSWD} <br><br>Thanks,<br>ERT Team");

define("SUB_NOT_REPORTING", APPNAME . " || Alert to report daily cron || ");
define("MESSAGE_NOT_REPORTING","Hi {NAME},<br><br>You didn't reported for the project {PROJECT} on {DATE}  <br><br>Thanks,<br>ERT Team");
?>
