<?php
Class AssignCheckList {
	
	function assignCheckList($postarray){
		global $dbcon;
		$assigned_check_list = (isset($postarray['check_list']) && (count($postarray['check_list']) > 0)) ? implode(",", $postarray['check_list']) : "";
		$date = gmdate("Y-m-d H:i:s");
		$select_q_content = "SELECT id FROM ".ASSIGN_CHECK_LIST." WHERE project_id = :project_id";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":project_id",$postarray['project']);
		$select_query->execute();
		$count = $select_query->rowCount();		
		if($count > 0){
			$msg = 2;		
		}else{															
			$query = "INSERT INTO `".ASSIGN_CHECK_LIST."`(`project_id`, `assigned_chek_list`, `created_at`) VALUES (:project_id, :assigned_chek_list, :created_at)";
			$insert_query = $dbcon->prepare($query);
			$insert_query->bindParam(":project_id", $postarray['project']);
			$insert_query->bindParam(":assigned_chek_list", $assigned_check_list);
			$insert_query->bindParam(":created_at", $date);
			$msg =  ($insert_query->execute()) ? 1 : 0;
			//print_r($insert_query->errorInfo());exit;
		}
		return $msg;
	}
	
	function getassignedCheckListCount(){
		global $dbcon;
		$sql = "SELECT count(id) as count FROM ".ASSIGN_CHECK_LIST." WHERE 1";
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
	
	function getAssignedCheckList(){
		global $dbcon,$start_limit;
		$customerData = "";
		$sql = "SELECT pca.id,pca.assigned_chek_list, p.name FROM ".ASSIGN_CHECK_LIST." as pca join projects as p on p.id = pca.project_id WHERE 1 ORDER BY p.id ASC LIMIT ".$start_limit.",".ROW_PER_PAGE;
		
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
	
	function getAssignedCheckListNames($checkListStr){
		global $dbcon,$start_limit;
		$customerData = "";
		$checkList = explode(",", $checkListStr);
		$qMarks = str_repeat('?,', count($checkList) - 1) . '?';
		$sql = "select group_concat(cp.question) as questions from ".CHECK_OPTIONS." as cp where cp.id in ($qMarks)";
		//$sql = "select question from ".CHECK_OPTIONS." as cp where cp.id in ($qMarks)";
		try {
            $stmt = $dbcon->prepare($sql);
            $stmt->execute($checkList);
			$customerData = $stmt->fetch(PDO::FETCH_ASSOC);
			return $customerData["questions"];
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}
	
	function getDataById($id){
		global $dbcon;
		$sql = "SELECT * FROM `".ASSIGN_CHECK_LIST."` WHERE id = ?";		
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
	
	function updateCheckList($postarray){
		global $dbcon;
		$assigned_check_list = (isset($postarray['check_list']) && (count($postarray['check_list']) > 0)) ? implode(",", $postarray['check_list']) : "";
		$date = gmdate("Y-m-d H:i:s");
		$select_q_content = "SELECT id FROM ".ASSIGN_CHECK_LIST." WHERE project_id = :project_id AND id != :id";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":project_id",$postarray['project']);
		$select_query->bindParam(":id",$postarray['id']);
		$select_query->execute();
		$count = $select_query->rowCount();		
		if($count > 0){
			$msg = 2;		
		}else{															
			$query = "UPDATE `".ASSIGN_CHECK_LIST."` SET `project_id` = :project_id, `assigned_chek_list` = :assigned_chek_list, `updated_at` = :updated_at WHERE id = :id";
			$insert_query = $dbcon->prepare($query);
			$insert_query->bindParam(":project_id", $postarray['project']);
			$insert_query->bindParam(":assigned_chek_list", $assigned_check_list);
			$insert_query->bindParam(":updated_at", $date);
			$insert_query->bindParam(":id", $postarray['id']);
			$msg =  ($insert_query->execute()) ? 1 : 0;
			//print_r($insert_query->errorInfo());exit;
		}
		return $msg;
	}
	
	function changeStatus($id,$status){
		global $dbcon,$moduleLabel;
		$update_q = "UPDATE ".ASSIGN_CHECK_LIST." SET status = :status WHERE id = :id";
		$update_query = $dbcon->prepare($update_q);
		$update_query->bindParam(":id",$id);
		$update_query->bindParam(":status",$status);
		$msg = ($update_query->execute()) ? 1 : 0;
		return $msg;
	}
	

	function delete($id){
		global $dbcon;		
		$sql = "DELETE FROM ".ASSIGN_CHECK_LIST." WHERE id = :id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":id",$id);
		return $sqlquery->execute();
	}	
	
}