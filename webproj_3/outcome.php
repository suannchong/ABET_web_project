<?php

	// retrieve email and password 
	$sectionId = $_GET['sectionId'];
	$major = $_GET['major'];

	$server = "dbs2.eecs.utk.edu";
	$usr = "schong3";
	$usr_pwd = "Csa316zx!@#";
	$db = "cosc465_schong3";

	$conn = mysqli_connect($server, $usr, $usr_pwd, $db);

	$query = 
		"SELECT o.outcomeId, o.outcomeDescription 
		FROM Outcomes o
		NATURAL JOIN CourseOutcomeMapping m 
		NATURAL JOIN Sections s 
		WHERE s.sectionId = ? AND m.major = ?
		ORDER BY o.outcomeId;";

	if ($stmt = mysqli_prepare($conn, $query)){
		mysqli_stmt_bind_param($stmt, "is", $sectionId, $major);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $outcomeId, $outcomeDescription);

		$myArr = array();

		while (mysqli_stmt_fetch($stmt)){
			$myObject = new \stdClass();
			$myObject->outcomeId = $outcomeId;
			$myObject->outcomeDescription = $outcomeDescription;

			array_push($myArr, $myObject);
		}

		$myJSON = json_encode($myArr);
		echo $myJSON;

		mysqli_stmt_close($stmt);
	}
	

?>