<?php

	$server = "dbs2.eecs.utk.edu";
	$usr = "schong3";
	$usr_pwd = "Csa316zx!@#";
	$db = "cosc465_schong3";

	$conn = mysqli_connect($server, $usr, $usr_pwd, $db);

	$query = 
		"SELECT a.sectionId, i.email, a.outcomeId, a.major, SUM(a.weight) AS weightTotal
		FROM Assessments a 
		NATURAL JOIN Sections s 
		NATURAL JOIN Instructors i 
		GROUP BY a.sectionId, a.outcomeId, a.major 
		HAVING SUM(a.weight) <> 100
		ORDER BY i.email, a.major, a.outcomeId;";

	if ($stmt = mysqli_prepare($conn, $query)){
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$sectionId, $email, $outcomeId, $major, $weightTotal);

		$myArr = array();

		while (mysqli_stmt_fetch($stmt)){
			$myObject = new \stdClass();
			$myObject->sectionId = $sectionId;
			$myObject->email = $email;
			$myObject->outcomeId = $outcomeId;
			$myObject->major = $major;
			$myObject->weightTotal = $weightTotal;

			array_push($myArr, $myObject);
		}

		$myJSON = json_encode($myArr);
		echo $myJSON;

		mysqli_stmt_close($stmt);
	}
	

?>