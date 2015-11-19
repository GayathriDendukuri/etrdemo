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
Class EmployeeProject {
	
	function getProjectNameById($id){
		global $dbcon;
		$name="";
		$select_q_content = "SELECT * FROM ".PROJECT." WHERE id = :id";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":id",$id);
		$select_query->execute();
		$count = $select_query->rowCount();		
		if($count > 0){
			$result = $select_query->fetch(PDO::FETCH_ASSOC);
			$name = $result['name'];
		}
		return $name;
	}
	
	function addReporting($postarray){
		
		global $dbcon;
		$data = serialize($postarray);
		$date = gmdate("Y-m-d H:i:s");
		$date = gmdate("Y-m-d");
		$select_q_content = "SELECT id FROM ".EMPLOYEE_REPORTING." WHERE employee_id = :employee_id AND project_id = :project_id AND date(created_at) = :created_at";
		$select_query = $dbcon->prepare($select_q_content);
		$select_query->bindParam(":employee_id",$postarray['emp_id']);
		$select_query->bindParam(":project_id",$postarray['project_id']);
		$select_query->bindParam(":created_at",$date);
		$select_query->execute();
		$count = $select_query->rowCount();	
		if($count > 0){
			$msg = 2;		
		}else{															
			$query = "INSERT INTO `".EMPLOYEE_REPORTING."`(`employee_id`, `project_id`, `data`, `created_at`) VALUES (:employee_id, :project_id, :data, :created_at)";
			$insert_query = $dbcon->prepare($query);
			$insert_query->bindParam(":employee_id",$postarray['emp_id']);
			$insert_query->bindParam(":project_id",$postarray['project_id']);
			$insert_query->bindParam(":data",$data);			
			$insert_query->bindParam(":created_at",$date);
			$msg =  ($insert_query->execute()) ? 1 : 0;
		}
		return $msg;
	}
	
	function getEmployeeProjectCount($id){
		global $dbcon;
		$sql = "SELECT count(id) as count FROM ".EMPLOYEE_PROJECT_ASSIGNMENT." WHERE employee_id = :employee_id";
		try {
            $stmt = $dbcon->prepare($sql);
			$stmt->bindParam(":employee_id", $id);
            $stmt->execute();
            $ruserData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $ruserData['count'];
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}
	
	function getEmployeeProjectList($id){
		global $dbcon,$start_limit;
		$customerData = "";
		
		$sql = "SELECT p.name as project_name, p.id as project_id,epa.* FROM ".EMPLOYEE_PROJECT_ASSIGNMENT." as epa join ".PROJECT." as p on p.id = epa.project_id  WHERE epa.employee_id = :employee_id ORDER BY id ASC LIMIT ".$start_limit.",".ROW_PER_PAGE;
		
        try {
            $stmt = $dbcon->prepare($sql);
            $stmt->bindParam(":employee_id", $id);
			$stmt->execute();
            return $customerData = $stmt->fetchALL(PDO::FETCH_ASSOC);
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}
	
	function getEmployeeProjectDataByProjectId($pId){
		global $dbcon,$start_limit;
		$customerData = "";
		
		$sql = "SELECT * FROM ".ASSIGN_CHECK_LIST." WHERE project_id = :project_id";
		
        try {
            $stmt = $dbcon->prepare($sql);
			$stmt->bindParam(":project_id", $pId);
			$stmt->execute();
            $customerData = $stmt->fetch(PDO::FETCH_ASSOC);
			$stmt = null;
			$checkList = explode(",", $customerData['assigned_chek_list']);			
			return $checkList;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}

	function getEmployeeProjectCheckOptionsData($checkList){
		global $dbcon;
		$customerData = "";
		$qMarks = str_repeat('?,', count($checkList) - 1) . '?';
		$sql1 = "SELECT * FROM ".CHECK_OPTIONS." WHERE id in ($qMarks)";
        try {
            $stmt1 = $dbcon->prepare($sql1);
			$stmt1->execute($checkList);
            $checkOptionsData = $stmt1->fetchAll(PDO::FETCH_ASSOC);
			$stmt1 = null;
			return $checkOptionsData;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}
	
	function getEmployeeProjectCheckOptionsDataInJson($projectCheckOptionsData){
		$result = array();
		foreach($projectCheckOptionsData as $checkOption){
			$temp = array();
			$temp['notes_for_yes'] = $checkOption['notes_for_yes'];
			$temp['notes_for_no'] = $checkOption['notes_for_no'];
			$key = $checkOption['id'];
		    $result[$key] = $temp;
		}
		 return json_encode($result);
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
	
	function changeStatus($id,$status){
		global $dbcon,$moduleLabel;
		$update_q = "UPDATE ".ASSIGN_CHECK_LIST." SET status = :status WHERE id = :id";
		$update_query = $dbcon->prepare($update_q);
		$update_query->bindParam(":id",$id);
		$update_query->bindParam(":status",$status);
		$msg = ($update_query->execute()) ? 1 : 0;
		return $msg;
	}
	

	function deleteCity($id){
		global $dbcon;		
		$sql = "DELETE FROM ".ASSIGN_CHECK_LIST." WHERE id = :id";
		$sqlquery = $dbcon->prepare($sql);
		$sqlquery->bindParam(":id",$id);
		return $sqlquery->execute();
	}
	
	function getZoneList(){
		global $dbcon,$start_limit;
		$zoneData = "";
		$sql = "SELECT * FROM ".ZONE." WHERE 1 AND country_id = 1 AND status = 1";
        try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
            return $zoneData = $stmt->fetchALL(PDO::FETCH_ASSOC);
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}
}