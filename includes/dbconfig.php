<?php

/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 22/01/2014                                      *
 * Created By : Pradeep G                                         *
 * Vision : Project Sparkle                                       *  
 * Modified by : Pradeep G     Date : 22/01/2014    Version : V1  *
 * Description : Make DB Connnection                              *
 *****************************************************************/



/* create connection */
try{
    //$dbcon = new PDO("mysql:host=localhost;dbname=qzytv", "root", "");
     // $dbcon = new PDO("mysql:host=localhost;dbname=oohnew", "root", "root");
      //$dbcon = new PDO("mysql:host=localhost;dbname=ooh", "oohuser", "oohuser");
	   //$dbcon = new PDO("mysql:host=localhost;dbname=ooh", "root", "");
	   $dbcon = new PDO("mysql:host=localhost;dbname=etr", "root", "");
            //$dbcon = new PDO("mysql:host=localhost;dbname=etr", "ertadmin", "ertadmin");
}
catch(PDOException $e){
    echo $e->getMessage();    
}


?>
