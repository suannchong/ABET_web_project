<?php
	session_start();

	$outcomeId = $_SESSION['outcomeId'];
	$sectionId = $_SESSION['sectionId'];
	$major = $_SESSION['major'];
	$performanceLevel =$_GET['performanceLevel'];
	$numberOfStudents = $_GET['numberOfStudents'];

	$server = "dbs2.eecs.utk.edu";
	$usr = "schong3";
	$usr_pwd = "Csa316zx!@#";
	$db = "cosc465_schong3";

	$conn = mysqli_connect($server, $usr, $usr_pwd, $db);

	$query = 
		"INSERT INTO OutcomeResults 
		VALUES (?, ?, ?, ?, ?)
		ON DUPLICATE KEY 
		UPDATE numberOfStudents = ?;";

	if ($stmt = mysqli_prepare($conn, $query)){
		mysqli_stmt_bind_param($stmt, "iissii", $sectionId, $outcomeId,  $major, $performanceLevel, $numberOfStudents, $numberOfStudents);
		mysqli_stmt_execute($stmt);

		mysqli_stmt_close($stmt);
	}
	

?>