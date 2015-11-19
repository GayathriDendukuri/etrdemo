<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 28/02/2014                                      *
 * Created By : Gayathri                                          *
 * Vision : Project InfoFam                                       *  
 * Modified by : Gayathri     Date : 17/03/2014    Version : V1   *
 * Description : This class is used to manage slider              *
				                                                  *
 *****************************************************************/
 //error_reporting(E_ALL);
/* error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");*/
Class Employee {

	function addEmployee($postarray){
		global $dbcon;
		$date = gmdate("Y-m-d H:i:s");
		$select_q_content = "SELECT id FROM ".ADMIN_LOGIN." WHERE email = :email AND delete_status = 0";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":email",$postarray['email']);
		$select_query->execute();
		$count = $select_query->rowCount();		
		if($count > 0){
			$msg = 2;		
		}else{	
			$password = $this->generatePassword();
			$md5 = md5($password);
			$query = "INSERT INTO `".EMPLOYEE."`(`fname`, `lname`, `email` ,`status`,`created_at`) VALUES (:fname, :lname, :email,:status, :created_at)";
			$insert_query = $dbcon->prepare($query);
			$insert_query->bindParam(":fname",$postarray['fname']);
			$insert_query->bindParam(":lname",$postarray['lname']);
			$insert_query->bindParam(":email",$postarray['email']);	
			$insert_query->bindValue(":status","1");				
			$insert_query->bindParam(":created_at",$date);
			$msg =  ($insert_query->execute()) ? 1 : 0;
			$lastInsertId = $dbcon->lastInsertId();
			//$insert_query = null;
			$query1 = "INSERT INTO `".ADMIN_LOGIN."` (`password`, `email`, `active_status`, `admin_type`, `employee_id`) VALUES (:password, :email, :active_status, :admin_type, :employee_id)";
			$active_status = 1;$admin_type = 2;
			$insert_query1 = $dbcon->prepare($query1);
			//$insert_query1->bindParam(":username", $postarray['uname']);
			$insert_query1->bindParam(":password", $md5);
			$insert_query1->bindParam(":email", $postarray['email']);			
			$insert_query1->bindParam(":active_status", $active_status);
			$insert_query1->bindParam(":admin_type", $admin_type);
			$insert_query1->bindParam(":employee_id", $lastInsertId);
			$msg =  ($insert_query1->execute()) ? 1 : 0;
			
			if($msg == 1){
				$name = $postarray['fname'] . " " . $postarray['lname'];	
				$subject = SUB_USER_ADD;
				$message = MESSAGE_USER_ADD;			
				$message = str_replace("{NAME}", $name, $message);
				$message = str_replace("{USERNAME}", $postarray['uname'], $message);
				$message = str_replace("{NEW_PSWD}", $password, $message);
				if(sendMail($postarray['email'], FROM_EMAIL, $subject, $message)){
					//echo "mail sent --- ";
				}else{
					//echo "mail not sent --- ";
				}
			}
			//exit;
			
		}
		
		return $msg;
	}
	
	function updateEmployee($postarray){
		global $dbcon;
		$date = gmdate("Y-m-d H:i:s");
		$select_q_content = "SELECT id FROM ".ADMIN_LOGIN." WHERE email = :email AND delete_status = 0 AND employee_id != :employee_id";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":email",$postarray['email']);
		$select_query->bindParam(":employee_id",$postarray['id']);
		$select_query->execute();
		$count = $select_query->rowCount();		
		if($count > 0){
			$msg = 2;		
		} else{			
			$query = "UPDATE `".EMPLOYEE."` SET `fname` = :fname, `lname` = :lname, `email` = :email, `updated_at` = :updated_at WHERE id = :id";
			$insert_query = $dbcon->prepare($query);
			$insert_query->bindParam(":fname",$postarray['fname']);
			$insert_query->bindParam(":lname",$postarray['lname']);
			$insert_query->bindParam(":email",$postarray['email']);			
			$insert_query->bindParam(":updated_at",$date);
			$insert_query->bindParam(":id",$postarray['id']);
			$msg =  ($insert_query->execute()) ? 1 : 0;
                        //print_r($insert_query->errorInfo());exit;
			//$insert_query = null;
			$query1 = "UPDATE `".ADMIN_LOGIN."` SET `email` = :email WHERE employee_id = :employee_id";
			$insert_query1 = $dbcon->prepare($query1);
			//$insert_query->bindParam(":username", $postarray['uname']);
			$insert_query1->bindParam(":email", $postarray['email']);
			$insert_query1->bindParam(":employee_id", $postarray['id']);
			$msg =  ($insert_query1->execute()) ? 1 : 0;
		}
		return $msg;
	}
	
	function getEmployeeCount(){
		global $dbcon;
		$sql = "SELECT count(id) as count FROM ".EMPLOYEE." WHERE delete_status = 0";
		try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
            $ruserData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $ruserData['count'];
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}
	
	function getEmployeeList(){
		global $dbcon,$start_limit;
		$customerData = "";
		$sql = "SELECT al.username, e.id, e.fname, e.lname, e.email FROM ".EMPLOYEE." as e join ".ADMIN_LOGIN." as al on al.employee_id = e.id WHERE e.delete_status = 0 ORDER BY e.id ASC LIMIT ".$start_limit.",".ROW_PER_PAGE;
		
        try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
            return $customerData = $stmt->fetchALL(PDO::FETCH_ASSOC);
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}
	
	function getAllEmployeeList(){
		global $dbcon;
		$customerData = "";
		$sql = "SELECT * FROM ".EMPLOYEE." WHERE delete_status = 0 ORDER BY id ASC ";		
        try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
            return $customerData = $stmt->fetchALL(PDO::FETCH_ASSOC);
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}
	
	function getDataById($id){
		global $dbcon;
		$sql = "SELECT al.username, e.id, e.fname, e.lname, e.email FROM ".EMPLOYEE." as e join ".ADMIN_LOGIN." as al on al.employee_id = e.id WHERE e.id = ?";		
		try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute(array($id));
            $customerData = $stmt->fetch(PDO::FETCH_ASSOC);
			return $customerData;
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
	}
	
	function changeStatus($id,$status){
		global $dbcon,$moduleLabel;
		$update_q = "UPDATE ".EMPLOYEE." SET status = :status WHERE id = :id";
		$update_query = $dbcon->prepare($update_q);
		$update_query->bindParam(":id",$id);
		$update_query->bindParam(":status",$status);
		$msg = ($update_query->execute()) ? 1 : 0;
		return $msg;
	}
	
	/*
	function delete($id){
		global $dbcon;	
		$sql = "DELETE FROM ".ADMIN_LOGIN." WHERE employee_id = :id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":id",$id);
		$sqlquery->execute();
		$sql = "DELETE FROM ".EMPLOYEE." WHERE id = :id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":id",$id);
		return $sqlquery->execute();
	}*/
	
	function delete($id){
		global $dbcon;	
		$sql = "UPDATE ".ADMIN_LOGIN." SET delete_status = 1 WHERE employee_id = :id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":id",$id);
		$sqlquery->execute();
		$sql = "UPDATE ".EMPLOYEE." SET delete_status = 1 WHERE id = :id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":id",$id);
		return $sqlquery->execute();
	}
	
	function generatePassword($length = 8) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$count = mb_strlen($chars);

		for ($i = 0, $result = ''; $i < $length; $i++) {
			$index = rand(0, $count - 1);
			$result .= mb_substr($chars, $index, 1);
		}

		return $result;
   }
	
}