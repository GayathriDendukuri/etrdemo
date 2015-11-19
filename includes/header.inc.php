<?php 

/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 22/01/2014                                      *
 * Created By : Pradeep G                                         *
 * Vision : Project Sparkle                                       *  
 * Modified by : Pradeep G     Date : 05/02/2014    Version : V1  *
 * Description : Header file - file includes,session, cookie
 * language selection, page content can be processed here         *
 *****************************************************************/
 
/* For Seesion initialize  */

session_start();
/* For display error report  */
error_reporting(0);

/* check logged session */

$logininfo = unserialize($_SESSION['ooh_logininfo']);

if($logininfo["username"]==""){
    if(basename($_SERVER['PHP_SELF']) != "login.php"){
        header("Location: login.php");
        exit;
    }
}

if(isset($_REQUEST["btnlogout"])){
    unset($_SESSION['ooh_logininfo']);
    header("Location: login.php");
    exit;
}



/* Includes config,db and table definitions and common functions files */

include("dbconfig.php");   //Creates db connection
include("configuration.php");  //Default configurations
include("function_common.php");  //Common functions , which can be used all over application often
include("tables.php");  //Table configurations

include("classes/messages.class.php");  //Table configurations
//exit;

?>
