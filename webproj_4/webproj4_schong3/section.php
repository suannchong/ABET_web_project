<?php

	// // start the session
	// session_start();

	// retrieve get instructorId from window.location.assign
	$instructorId = $_GET['instructorId'];

	// set session variables
	$_SESSION['instructorId'] = $instructorId;

	$server = "dbs2.eecs.utk.edu";
	$usr = "schong3";
	$usr_pwd = "Csa316zx!@#";
	$db = "cosc465_schong3";

	$conn = mysqli_connect($server, $usr, $usr_pwd, $db);

	$query_sections = 
		"SELECT DISTINCT s.sectionId, s.courseId, m.major, s.semester, s.year FROM Sections s NATURAL JOIN CourseOutcomeMapping m WHERE s.instructorId = 13 ORDER BY s.year DESC, s.semester ASC;";

	if ($stmt_sections = mysqli_prepare($conn, $query_sections)){
		mysqli_stmt_bind_param($stmt_sections, "i", $instructorId);
		mysqli_stmt_execute($stmt_sections);
		mysqli_stmt_bind_result($stmt_sections, $sectionId, $courseId, $major, $semester, $year);

		$myArr_sections = array();

		while (mysqli_stmt_fetch($stmt_sections)){
			$mySectionObject = new \stdClass();
			$mySectionObject->sectionId = $sectionId;
			$mySectionObject->courseId = $courseId;
			$mySectionObject->major = $major;
			$mySectionObject->semester = $semester;
			$mySectionObject->year = $year;

			array_push($myArr_sections, $mySectionObject);
		}

		mysqli_stmt_close($stmt_sections);
	}


	
?>