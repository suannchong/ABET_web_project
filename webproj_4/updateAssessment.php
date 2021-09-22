<?php

	$assessmentId = $_GET['assessmentId'];
	$sectionId = $_GET['sectionId'];
	$assessmentDescription = $_GET['assessmentDescription'];
	$weight = $_GET['weight'];
	$outcomeId = $_GET['outcomeId'];
	$major = $_GET['major'];
	
	$server = "dbs2.eecs.utk.edu";
	$usr = "schong3";
	$usr_pwd = "Csa316zx!@#";
	$db = "cosc465_schong3";

	$conn = mysqli_connect($server, $usr, $usr_pwd, $db);

	$query = 
		"INSERT INTO Assessments 
		VALUES (?, ?, ?, ?, ?,  ?)
		ON DUPLICATE KEY 
		UPDATE sectionId = ?, assessmentDescription = ?, weight = ? , outcomeId = ? , major = ?;";

	if ($stmt = mysqli_prepare($conn, $query)){
		mysqli_stmt_bind_param($stmt, "iisiisisiis", $assessmentId, $sectionId, $assessmentDescription, $weight, $outcomeId, $major, $sectionId, $assessmentDescription, $weight, $outcomeId, $major);
		mysqli_stmt_execute($stmt);

		mysqli_stmt_close($stmt);
	}
	

?>