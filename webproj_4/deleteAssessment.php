<?php

	$assessmentId = $_GET['assessmentId'];
	
	$server = "dbs2.eecs.utk.edu";
	$usr = "schong3";
	$usr_pwd = "Csa316zx!@#";
	$db = "cosc465_schong3";

	$conn = mysqli_connect($server, $usr, $usr_pwd, $db);

	$query = 
		"DELETE FROM Assessments
		WHERE assessmentId = ?;";


	if ($stmt = mysqli_prepare($conn, $query)){
		mysqli_stmt_bind_param($stmt, "i", $assessmentId);
		mysqli_stmt_execute($stmt);

		mysqli_stmt_close($stmt);
	}
	

?>