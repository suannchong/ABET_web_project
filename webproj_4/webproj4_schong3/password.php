<?php

	// start the session
	session_start();

	// set session variables
	$instructorId = $_SESSION['instructorId'];

	$server = "dbs2.eecs.utk.edu";
	$usr = "schong3";
	$usr_pwd = "Csa316zx!@#";
	$db = "cosc465_schong3";

	$conn = mysqli_connect($server, $usr, $usr_pwd, $db);

	// Getting the sections given an instructorId
	$query_sections = 
		"SELECT DISTINCT s.sectionId, s.courseId, m.major, s.semester, s.year
		FROM Sections s
		NATURAL JOIN CourseOutcomeMapping m
		WHERE s.instructorId = ?
		ORDER BY s.year DESC, s.semester DESC;";

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


<html lang="en">

	<meta name="viewport" charset="utf-8" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="password.css">
	
	<title> Change Password Page </title>
	<body> 

		<header>
			<div id="abet"> UTK ABET </div>
			<div id="profile" class="dropdown">
			 	<button onclick="myFunction()" class="dropbtn">
			  		<img src="person-fill.svg" class="person"> 
					<img src="caret-down-fill.svg" class="person">
				</button>

					<div id="myDropdown" class="dropdown-content">
					    <a onclick="changePasswordHandler()">Change Password</a>
					    <a onclick="logoutHandler()">Logout</a>
				  	</div>
			 	
			</div>
<script>
	/* When the user clicks on the button, 
	toggle between hiding and showing the dropdown content */
	function myFunction() {
	  document.getElementById("myDropdown").classList.toggle("show");
	}

	function changePasswordHandler(){
		window.location.assign("password.php");
	}

	function logoutHandler(){
		window.location.assign("login.html");
	}

	// Close the dropdown if the user clicks outside of it
	window.onclick = function(event) {
	  if (!event.target.matches('.dropbtn')) {
	    var dropdowns = document.getElementsByClassName("dropdown-content");
	    var i;
	    for (i = 0; i < dropdowns.length; i++) {
	      var openDropdown = dropdowns[i];
	      if (openDropdown.classList.contains('show')) {
	        openDropdown.classList.remove('show');
	      }
	    }
	  }
	}
</script>

		</header>

		<div id="container">
			<nav>
				<div class="section">
					<div> Section: </div>
					<div class="custom-select">
					<form method="post" action="">
						<select name="Sections" id="Sections">
<?php

	$i = 0;
	foreach ($myArr_sections as $section) {
	    echo "<option value=" . $i . '> ' . $section->courseId . ' ' . $section->semester . ' ' . $section->year . ' ' . $section->major .' ' . "</option>";
	    $i = $i + 1;
	}
?>
						</select>
						<span class="custom-arrow"></span>
					</form>
						
						
					</div>
					
				</div> 
				
<?php

	// Loading the first section from the dropdown menu

	$selected = $myArr_sections[0];

	$selected_sectionId = $selected->sectionId;
	$selected_major = $selected->major;

	$_SESSION['sectionId'] = $selected_sectionId;
	$_SESSION['major'] = $selected_major;

	$query_outcome = 
		"SELECT o.outcomeId, o.outcomeDescription 
		FROM Outcomes o
		NATURAL JOIN CourseOutcomeMapping m 
		NATURAL JOIN Sections s 
		WHERE s.sectionId = ? AND m.major = ?
		ORDER BY o.outcomeId;";

	if ($stmt_outcome = mysqli_prepare($conn, $query_outcome)){
		mysqli_stmt_bind_param($stmt_outcome, "is", $selected_sectionId, $selected_major);
		mysqli_stmt_execute($stmt_outcome);
		mysqli_stmt_bind_result($stmt_outcome, $outcomeId, $outcomeDescription);

		$myArr_outcome = array();

		while (mysqli_stmt_fetch($stmt_outcome)){
			$myOutcomeObject = new \stdClass();
			$myOutcomeObject->outcomeId = $outcomeId;
			$myOutcomeObject->outcomeDescription = $outcomeDescription;

			array_push($myArr_outcome, $myOutcomeObject);
		}

		mysqli_stmt_close($stmt_outcome);
	}

	foreach ($myArr_outcome as $outcome){
		echo " <div id='outcome'> Outcome " . $outcome->outcomeId . "  </div> ";
	}

?>
			</nav>

			<main>
				<h1> Change Password </h1>
				<div id="basic-info-header"> Basic info</div>
				<div class="basic-infos">
					<div class="basic-info name"> <strong> Name: </strong>  
					Wily Coyote
<?php
	// get name and email given an instructorId 
	// send AJAX request to get data from the database 
?>
				</div>
					<div class="basic-info email"> <strong> Email: </strong> coyote@utk.edu</div>
				</div>

<script type="text/javascript">
	function passwordCheck(event){
		
		var p1 = document.getElementById("new-password").value;
		var p2 = document.getElementById("confirm-password").value;
		var msg = document.getElementById("passwordMsg");

		if (p1 != p2){
			msg.style.color = "red";
			msg.innerHTML = "passwords do not match-- please make them match";
			msg.style.visibility  = "visible";

		} else {
			msg.style.visibility  = "hidden";
		}

		event.preventDefault();

		return false;		
	}

</script>
				
				<div id="change-password-header"> Change Password </div>
				<form>
					<div class="change-password">
						<strong> New Password</strong>
						<input type="password" id="new-password" maxlength="20">
						<strong> Confirm Password</strong>
						<input type="password" id="confirm-password" maxlength="20">
						
						<input type="submit" name="Submit" onclick="passwordCheck(this)"> <span id="passwordMsg"> </span>
						
					</div>
				</form>


				

			</main>
		</div>

	</body>
</html>