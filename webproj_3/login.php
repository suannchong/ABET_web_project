<?php

	// retrieve email and password 
	$email = $_GET['email'];
	$password = $_GET['password'];

	$server = "dbs2.eecs.utk.edu";
	$usr = "schong3";
	$usr_pwd = "Csa316zx!@#";
	$db = "cosc465_schong3";

	$conn = mysqli_connect($server, $usr, $usr_pwd, $db);

	$query = 
		"SELECT DISTINCT s.instructorId, s.sectionId, s.courseId, m.major, s.semester, s.year
		FROM Instructors i
		NATURAL JOIN Sections s
		NATURAL JOIN CourseOutcomeMapping m
		WHERE i.email = ? 
		AND i.password=PASSWORD(?) 
		ORDER BY s.year DESC, s.semester ASC;";

	if ($stmt = mysqli_prepare($conn, $query)){
		mysqli_stmt_bind_param($stmt, "ss", $email, $password);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $instructorId, $sectionId, $courseId, $major, $semester, $year);

		$myArr = array();

		while (mysqli_stmt_fetch($stmt)){
			$myObject = new \stdClass();
			$myObject->instructorId = $instructorId;
			$myObject->sectionId = $sectionId;
			$myObject->courseId = $courseId;
			$myObject->major = $major;
			$myObject->semester = $semester;
			$myObject->year = $year;

			array_push($myArr, $myObject);
		}

		$myJSON = json_encode($myArr);
		echo $myJSON;

		mysqli_stmt_close($stmt);
	}
	

?>