<?php
//error_reporting (E_ALL ^ E_NOTICE);
Class Login{
	
	function authendication($username,$password){ 
		global $dbcon;
		$newpassword = md5($password);	
		
		//$query = "SELECT * FROM `".ADMIN_LOGIN."` WHERE `username` = :username AND `password` = :password";
		$query = "SELECT * FROM `".ADMIN_LOGIN."` WHERE `email` = :username AND `password` = :password AND delete_status = 0";
		$select_query = $dbcon->prepare($query);
        $select_query->bindParam(":username",$username);
		$select_query->bindParam(":password",$newpassword);
		$select_query->execute();				
		if($select_query->rowCount() > 0){
			return $select_query_result = $select_query->fetch();
		}
		return "";
	}	
}
?>
