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
Class CheckOption {

	function addCheckOption($postarray){
		global $dbcon;
		$notes_for_yes = (isset($postarray['notes_for_yes'])) ? $postarray['notes_for_yes'] : "";
		$notes_for_no = (isset($postarray['notes_for_no'])) ? $postarray['notes_for_no'] : "";
		
		$date = gmdate("Y-m-d H:i:s");
		$select_q_content = "SELECT id FROM ".CHECK_OPTIONS." WHERE question = :question AND delete_status = 0";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":question",$postarray['question']);
		$select_query->execute();
		$count = $select_query->rowCount();
		if($count > 0){
			$msg = 2;		
		}else{															
			$query = "INSERT INTO `".CHECK_OPTIONS."`(`question`, `description`, `notes_for_yes`, `notes_for_no`, `created_at`) VALUES (:question, :description, :notes_for_yes, :notes_for_no, :created_at)";
			$insert_query = $dbcon->prepare($query);
			$insert_query->bindParam(":question",$postarray['question']);
			$insert_query->bindParam(":description",$postarray['description']);
			$insert_query->bindParam(":notes_for_yes",$notes_for_yes);$insert_query->bindParam(":notes_for_no",$notes_for_no);
			$insert_query->bindParam(":created_at",$date);
			$msg =  ($insert_query->execute()) ? 1 : 0;
			//print_r($insert_query->errorInfo());exit;
		}
		return $msg;
	}
	
	function UpdateCheckOption($postarray){
		global $dbcon;
		$notes_for_yes = (isset($postarray['notes_for_yes'])) ? $postarray['notes_for_yes'] : "";
		$notes_for_no = (isset($postarray['notes_for_no'])) ? $postarray['notes_for_no'] : "";
		
		$date = gmdate("Y-m-d H:i:s");
		$select_q_content = "SELECT id FROM ".CHECK_OPTIONS." WHERE question = :question AND delete_status = 0 AND id != :id";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":question",$postarray['question']);
		$select_query->bindParam(":id",$postarray['id']);
		$select_query->execute();
		$count = $select_query->rowCount();		
		if($count > 0){
			$msg = 2;		
		}else{															
			$query = "UPDATE `".CHECK_OPTIONS."` SET `question` = :question, `description` = :description, `notes_for_yes` = :notes_for_yes, `notes_for_no` = :notes_for_no, `updated_at` = :updated_at WHERE id = :id";
			$insert_query = $dbcon->prepare($query);
			$insert_query->bindParam(":question",$postarray['question']);
			$insert_query->bindParam(":description",$postarray['description']);
			$insert_query->bindParam(":notes_for_yes",$notes_for_yes);
			$insert_query->bindParam(":notes_for_no",$notes_for_no);
			$insert_query->bindParam(":updated_at",$date);
			$insert_query->bindParam(":id",$postarray['id']);
			$msg =  ($insert_query->execute()) ? 1 : 0;
			//print_r($insert_query->errorInfo());exit;
		}
		return $msg;
	}
	
	function getCheckCount(){
		global $dbcon;
		$sql = "SELECT count(id) as count FROM ".CHECK_OPTIONS." WHERE delete_status = 0";
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
	
	function getCheckList(){
		global $dbcon,$start_limit;
		$customerData = "";
		$sql = "SELECT * FROM ".CHECK_OPTIONS." WHERE delete_status = 0 ORDER BY id ASC LIMIT ".$start_limit.",".ROW_PER_PAGE;
		
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
	
	function getAllCheckList(){
		global $dbcon;
		$customerData = "";
		$sql = "SELECT * FROM ".CHECK_OPTIONS." WHERE delete_status = 0 ORDER BY id ASC ";
		
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
		$sql = "SELECT * FROM `".CHECK_OPTIONS."` WHERE id = ?";		
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
		$update_q = "UPDATE ".CHECK_OPTIONS." SET status = :status WHERE id = :id";
		$update_query = $dbcon->prepare($update_q);
		$update_query->bindParam(":id",$id);
		$update_query->bindParam(":status",$status);
		$msg = ($update_query->execute()) ? 1 : 0;
		return $msg;
	}
	

	/*function delete($id){
		global $dbcon;		
		$sql = "DELETE FROM ".CHECK_OPTIONS." WHERE id = :id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":id",$id);
		return $sqlquery->execute();
	}*/
	
	function delete($id){
		global $dbcon;		
		$sql = "UPDATE ".CHECK_OPTIONS." SET delete_status = 1 WHERE id = :id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":id",$id);
		return $sqlquery->execute();
	}
	
}