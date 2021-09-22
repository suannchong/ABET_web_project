<?php

	// start the session
	session_start();

	// retrieve email and password 
	$email = $_POST['email'];
	$password = $_POST['password'];

	// set session variables
	$_SESSION['email'] = $email;
	$_SESSION['password'] = $password;

	$server = "dbs2.eecs.utk.edu";
	$usr = "schong3";
	$usr_pwd = "Csa316zx!@#";
	$db = "cosc465_schong3";

	$conn = mysqli_connect($server, $usr, $usr_pwd, $db);

	$query = 
		"SELECT DISTINCT i.instructorId
		FROM Instructors i
		WHERE i.email = ? 
		AND i.password=PASSWORD(?);";

	if ($stmt = mysqli_prepare($conn, $query)){
		mysqli_stmt_bind_param($stmt, "ss", $email, $password);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $instructorId);
		mysqli_stmt_fetch($stmt);
		echo json_encode($instructorId);

		$_SESSION['instructorId'] = $instructorId;
		mysqli_stmt_close($stmt);
	} else {
		echo json_encode("sql statement has an error");
	}
	

?>