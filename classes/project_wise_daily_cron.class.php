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
Class PROJECT_WISE_DAILY_CRON {

	function getEmployeeNotReported($pId, $date){
		$ruserData = array();
		global $dbcon;
		$sql = "SELECT * FROM `employee_project_assignment` where employee_id not in (select employee_id from employee_reporting where date(created_at) = :created_at  AND `project_id` = :project_id) AND `project_id` = :project_id1";
		$select_query = $dbcon->prepare($sql);
		$select_query->bindParam(":created_at",$date);
		$select_query->bindParam(":project_id",$pId);
		$select_query->bindParam(":project_id1",$pId);
		$select_query->execute();
		$count = $select_query->rowCount();
		if($count > 0){
			$ruserData = $select_query->fetchAll(PDO::FETCH_ASSOC);
			//print_r($select_query->errorInfo());exit;
		}
		return $ruserData;
	}
		
	function getAllAssignedProjectsHavingChecksList(){
		global $dbcon;
		$data = "";
		//$sql = "SELECT * FROM ".EMPLOYEE_PROJECT_ASSIGNMENT." WHERE 1 ORDER BY id ASC ";		
		$sql = "select e.id as employee_id, epa.project_id as project_id from employee e ,employee_project_assignment epa ,project_checklist_assignment pca where e.id = epa.employee_id and epa.project_id = pca.project_id ";
        try {
            $stmt = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
            $stmt->execute();
            return $data = $stmt->fetchALL(PDO::FETCH_ASSOC);
            $stmt = null;
        }catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
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
		$sql = "SELECT * FROM ".ASSIGN_CHECK_LIST." WHERE 1 ORDER BY id ASC LIMIT ".$start_limit.",".ROW_PER_PAGE;
		
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