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
Class Project {

	function addProject($postarray){	
		global $dbcon;
		$date = gmdate("Y-m-d H:i:s");
		$select_q_content = "SELECT id FROM ".PROJECT." WHERE name = :name AND delete_status = 0";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":name",$postarray['name']);
		$select_query->execute();
		$count = $select_query->rowCount();		
		if($count > 0){
			$msg = 2;		
		}else{															
			$query = "INSERT INTO `".PROJECT."`(`name`, `description`, `status`, `created_at`) VALUES (:name, :description, :status, :created_at)";
			$insert_query = $dbcon->prepare($query);
			$insert_query->bindParam(":name",$postarray['name']);
			$insert_query->bindParam(":description",$postarray['description']);
			$insert_query->bindParam(":status",$postarray['active_status']);			
			$insert_query->bindParam(":created_at",$date);
			$msg =  ($insert_query->execute()) ? 1 : 0;
		}
		return $msg;
	}
	
	function updateProject($postarray){	
		global $dbcon;
		$date = gmdate("Y-m-d H:i:s");
		$select_q_content = "SELECT id FROM ".PROJECT." WHERE name = :name AND delete_status = 0 AND id != :id";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":name",$postarray['name']);
		$select_query->bindParam(":id",$postarray['id']);
		$select_query->execute();
		$count = $select_query->rowCount();		
		if($count > 0){
			$msg = 2;		
		}else{															
			$query = "UPDATE `".PROJECT."` SET `name` = :name, `description` = :description, `status` = :status, `updated_at` = :updated_at WHERE id = :id";
			$insert_query = $dbcon->prepare($query);
			$insert_query->bindParam(":name",$postarray['name']);
			$insert_query->bindParam(":description",$postarray['description']);
			$insert_query->bindParam(":status",$postarray['active_status']);			
			$insert_query->bindParam(":updated_at",$date);
			$insert_query->bindParam(":id",$postarray['id']);
			$msg =  ($insert_query->execute()) ? 1 : 0;
		}
		return $msg;
	}
	
	function getProjectCount(){
		global $dbcon;
		$sql = "SELECT count(id) as count FROM ".PROJECT." WHERE delete_status = 0";
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
	
	function getProjectList(){
		global $dbcon,$start_limit;
		$customerData = "";
		$sql = "SELECT * FROM ".PROJECT." WHERE delete_status = 0 ORDER BY id ASC LIMIT ".$start_limit.",".ROW_PER_PAGE;
		
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
	
	function getAllProjectList(){
		global $dbcon;
		$customerData = "";
		$sql = "SELECT * FROM ".PROJECT." WHERE delete_status = 0 ORDER BY id ASC ";		
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
		$sql = "SELECT * FROM `".PROJECT."` WHERE id = ?";		
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
		$update_q = "UPDATE ".PROJECT." SET status = :status WHERE id = :id";
		$update_query = $dbcon->prepare($update_q);
		$update_query->bindParam(":id",$id);
		$update_query->bindParam(":status",$status);
		$msg = ($update_query->execute()) ? 1 : 0;
		return $msg;
	}
	
	/*
	function delete($id){
		global $dbcon;		
		$sql = "DELETE FROM ".PROJECT." WHERE id = :id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":id",$id);
		return $sqlquery->execute();
	}
	*/
	function delete($id){
		global $dbcon;		
		$sql = "UPDATE ".PROJECT." SET delete_status = 1 WHERE id = :id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":id",$id);
		return $sqlquery->execute();
	}
	
}