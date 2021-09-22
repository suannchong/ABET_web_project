<?php

	$sectionId = $_GET['sectionId'];
	$major = $_GET['major'];
	$outcomeId = $_GET['outcomeId'];
	$strengths = $_GET['strengths'];
	$weaknesses = $_GET['weaknesses'];
	$actions = $_GET['actions'];
	
	$server = "dbs2.eecs.utk.edu";
	$usr = "schong3";
	$usr_pwd = "Csa316zx!@#";
	$db = "cosc465_schong3";

	$conn = mysqli_connect($server, $usr, $usr_pwd, $db);

	$query = 
		"INSERT INTO Narratives 
		VALUES (?, ?, ?, ?, ?, ?)
		ON DUPLICATE KEY 
		UPDATE strengths = ?, weaknesses = ? , actions = ?;";


	if ($stmt = mysqli_prepare($conn, $query)){
		mysqli_stmt_bind_param($stmt, "isissssss", $sectionId, $major, $outcomeId, $strengths, $weaknesses, $actions, $strengths, $weaknesses, $actions);
		mysqli_stmt_execute($stmt);

		mysqli_stmt_close($stmt);
	}
	
?>