<?php

	// retrieve email and password 
	$major = $_GET['major'];
	$outcomeId = $_GET['outcome'];
	$sectionId = $_GET['sectionId'];
	

	$server = "dbs2.eecs.utk.edu";
	$usr = "schong3";
	$usr_pwd = "Csa316zx!@#";
	$db = "cosc465_schong3";

	$conn = mysqli_connect($server, $usr, $usr_pwd, $db);

	$query = 
		"SELECT a.assessmentDescription, a.weight
		FROM Assessments a 
		WHERE a.major = ? AND a.outcomeId = ? AND a.sectionId = ?
		ORDER BY a.weight DESC, a.assessmentDescription ASC;";

	if ($stmt = mysqli_prepare($conn, $query)){
		mysqli_stmt_bind_param($stmt, "sii", $major, $outcomeId, $sectionId);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$assessmentDescription, $weight);

		$myArr = array();

		while (mysqli_stmt_fetch($stmt)){
			$myObject = new \stdClass();
			$myObject->assessmentDescription = $assessmentDescription;
			$myObject->weight = $weight;

			array_push($myArr, $myObject);
		}

		$myJSON = json_encode($myArr);
		echo $myJSON;

		mysqli_stmt_close($stmt);
	}
	

?>