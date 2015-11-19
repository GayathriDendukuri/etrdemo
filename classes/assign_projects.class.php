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
Class Assign_Projects {

	function addAssignProject($postarray){	
		global $dbcon;
		$date = gmdate("Y-m-d H:i:s");
		$select_q_content = "SELECT id FROM ".EMPLOYEE_PROJECT_ASSIGNMENT." WHERE employee_id = :employee_id AND project_id = :project_id";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":employee_id",$postarray['employee']);
		$select_query->bindParam(":project_id",$postarray['project']);
		$select_query->execute();
		$count = $select_query->rowCount();		
		if($count > 0){
			$msg = 2;		
		}else{		
			$query = "INSERT INTO `".EMPLOYEE_PROJECT_ASSIGNMENT."` (`employee_id`, `project_id`, `created_at`, `status`) VALUES (:employee_id, :project_id, :created_at, :status)";
			$insert_query = $dbcon->prepare($query);
			$insert_query->bindParam(":employee_id",$postarray['employee']);
			$insert_query->bindParam(":project_id",$postarray['project']);
			$insert_query->bindParam(":status",$postarray['active_status']);	$insert_query->bindParam(":created_at",$date);
			$msg =  ($insert_query->execute()) ? 1 : 0;
		}
		return $msg;
	}
	
	function updateAssignProject($postarray){	
		global $dbcon;
		$date = gmdate("Y-m-d H:i:s");
		$select_q_content = "SELECT id FROM ".EMPLOYEE_PROJECT_ASSIGNMENT." WHERE employee_id = :employee_id AND  project_id = :project_id AND id != :id";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":employee_id",$postarray['employee']);
		$select_query->bindParam(":project_id",$postarray['project']);
		$select_query->bindParam(":id",$postarray['id']);
		$select_query->execute();
		$count = $select_query->rowCount();		
		if($count > 0){
			$msg = 2;		
		}else{															
			$query = "UPDATE `".EMPLOYEE_PROJECT_ASSIGNMENT."` SET `employee_id` = :employee_id, `project_id` = :project_id, `updated_at` = :updated_at WHERE id = :id";
			$insert_query = $dbcon->prepare($query);
			$insert_query->bindParam(":employee_id",$postarray['employee']);
			$insert_query->bindParam(":project_id",$postarray['project']);		
			$insert_query->bindParam(":updated_at",$date);
			$insert_query->bindParam(":id",$postarray['id']);
			$msg =  ($insert_query->execute()) ? 1 : 0;
		}
		return $msg;
	}
	
	function getEmployeeProjectsCount(){
		global $dbcon;
		$sql = "SELECT count(id) as count FROM ".EMPLOYEE_PROJECT_ASSIGNMENT." WHERE 1";
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
	
	function getEmployeeProjectsList(){
		global $dbcon,$start_limit;
		$customerData = "";
		$sql = "SELECT e.fname as employee_fname, p.name as project_name, p.id as project_id,epa.id as id FROM ".EMPLOYEE_PROJECT_ASSIGNMENT." as epa join ".PROJECT." as p on p.id = epa.project_id join ".EMPLOYEE." as e on e.id = epa.employee_id WHERE 1 ORDER BY id ASC LIMIT ".$start_limit.",".ROW_PER_PAGE;
		
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
	
	function getAllProjectListHavingChecklist(){
		global $dbcon;
		$customerData = "";
		 
		//$sql = "SELECT * FROM ".PROJECT." p, ".ASSIGN_CHECK_LIST." WHERE p.id = pca.project_id AND p.delete_status = 0 ORDER BY p.id ASC";	
		$sql = "SELECT p.id, p.name FROM projects p, project_checklist_assignment pca WHERE p.id = pca.project_id AND p.delete_status = 0 ORDER BY p.id ASC ";
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
//$sql = "SELECT e.fname as employee_fname, p.name as project_name, p.id as project_id,epa.id as id FROM ".EMPLOYEE_PROJECT_ASSIGNMENT." as epa join ".PROJECT." as p on p.id = epa.project_id join ".EMPLOYEE." as e on e.id = epa.employee_id WHERE epa.id = ?";
		$sql = "SELECT * FROM ".EMPLOYEE_PROJECT_ASSIGNMENT." WHERE id = ?";		
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
		$update_q = "UPDATE ".EMPLOYEE_PROJECT_ASSIGNMENT." SET status = :status WHERE id = :id";
		$update_query = $dbcon->prepare($update_q);
		$update_query->bindParam(":id",$id);
		$update_query->bindParam(":status",$status);
		$msg = ($update_query->execute()) ? 1 : 0;
		return $msg;
	}	

	function delete($id){
		global $dbcon;		
		$sql = "DELETE FROM ".EMPLOYEE_PROJECT_ASSIGNMENT." WHERE id = :id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":id",$id);
		return $sqlquery->execute();
	}
	
}