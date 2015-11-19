<?php
include('includes/header.inc.php');
if($logininfo["admin_type"] == "1")
					header("Location:project.php");
				else
					header("Location:employee_project.php");
//header('Location: project.php');

?>