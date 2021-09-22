<?php

	// start the session
	session_start();

	// retrieve get instructorId from window.location.assign
	$instructorId = $_GET['instructorId'];

	// set session variables
	$_SESSION['instructorId'] = $instructorId;

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
		ORDER BY s.year DESC, s.semester ASC;";

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
	<link rel="stylesheet" href="abet.css">
	
	<title> Data Collection Page </title>
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
						<select name="Sections" id="Sections" onchange="selectedSectionHandler(this)">
<?php
	// Populate all the sections taught by the instructor 
	$i = 0;
	foreach ($myArr_sections as $section) {
	    echo "<option value=" . $i . '> ' . $section->courseId . ' ' . $section->semester . ' ' . $section->year . ' ' . $section->major .' ' . "</option>";
	    $i = $i + 1;
	}
?>
						</select>
						<span class="custom-arrow"></span>

<script type="text/javascript">
	function selectedSectionHandler(event){
		// console.log(event.selectedIndex);
		// var selectedIndex = event.selectedIndex;
		// var query = "selectedIndex=" + selectedIndex;

		// ajaxreq = new XMLHttpRequest();
		// ajaxreq.open("POST", "getSectionIndex.php");
		// ajaxreq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		// ajaxreq.responseType="json";
		// ajaxreq.send(query);
	}

</script>
					</div>
					
				</div> 
				
<?php

	// Loading the first section from the dropdown menu
	
	$index = 0;
	if (isset($_POST["selectedIndex"])){
		$index = $_POST["selectedIndex"];
		echo "selected index: " . json_encode($index);
	}

	$selected = $myArr_sections[$index];

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
				<div class="results">
					<h1>Results </h1> 
					<p> Please enter the number of students who do not meet expectations, meet expectations, and exceed expectations. You can type directly into the boxes -- you do not need to use the arrows.</p>

<?php
	// Display the first outcome 
	$first_outcome = $myArr_outcome[0];

	echo "<div id='outcome-description'>  <strong> Outcome " . $first_outcome->outcomeId . " - " . $selected_major . ": </strong>" . $first_outcome->outcomeDescription . "</div>";
?>

					<form id="result-form">
						<div class="scores">
							<div class="score one"> 
								<h2> Not Meets Expectations </h2>
								<input type="number" name="qty" min="0" onblur="findTotal()">
							</div>
							<div class="score two"> 
								<h2> Meets Expectations </h2>
								<input type="number" name="qty" min="0" onblur="findTotal()">
							</div>
							<div class="score three"> 
								<h2> Exceeds Expectations </h2>
								<input type="number" name="qty" min="0" onblur="findTotal()">
							</div>
							<div class="score total"> 
								<h2> Total </h2>
								<span id="total"> </span>
							</div>

	<script type="text/javascript">
		function findTotal(){
    		var arr = document.getElementsByName('qty');
		    var tot=0;
		    for(var i=0;i<arr.length;i++){
		        if(parseInt(arr[i].value))
		            tot += parseInt(arr[i].value);
		    }
		    document.getElementById('total').innerHTML = tot;
		}

    </script>
						</div>	
					</form>

					<input type="submit" value="Save Results" id="submit-result" onclick="saveResult()">

	<script type="text/javascript">
		function saveResult(){
			// event.preventDefault();

			// ajaxreq = new XMLHttpRequest();
			// ajaxreq.open("POST", "updateResults.php");
			// ajaxreq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			// ajaxreq.responseType="json";
			// ajaxreq.addEventListener("load", updateResultCallback);
			// ajaxreq.send(query);

			let resultMsg = document.getElementById("resultMsg");
			resultMsg.style.visibility = "visible";
			setTimeout(function(){document.getElementById("resultMsg").style.visibility="hidden";}, 3000);
		}

		// function updateResultCallback(){
		// 	result = this.response;

		// 	if (!result){
		// 		// result is not saved
		// 		// let resultMsg = document.getElementById("resultMsg");
		// 	} else {
		// 		// result successfully saved 
		// 		let resultMsg = document.getElementById("resultMsg");
		// 		resultMsg.style.visibility = "visible"
		// 		setTimeout(function(){document.getElementById("resultMsg").style.visibility="hidden", 3000});
		// 	}
		// }

	</script>
				<span id="resultMsg"> results successfully saved </span>
				</div>

				<div class="assessments">
					<h1> Assessment Plan </h1>
					<p>
						<ol> 
							<li> Please enter your assessment plan for each outcome. The weights are percentages from 0-100 and the weights should add up to 100%. 
							<li> Always press "Save Assessments" when finished, even if you removed an assessment. The trash can only remove an assessment from this screen-it does not remove it from the database until you press "Save Assessments". 
						</ol>
					</p>

					<form id="assessment-form">
					<div id=assessment-plans>
						<!-- Row 1 -->
						<div class="plans">
							<div class="assessment weight"> 
								<h2> Weights (%) </h2>
								<input type="number" name="weight" min="0" max="100" >
							</div>
							<div class="assessment description"> 
								<h2> Description </h2>
								<!-- <input type="text" name="description"> -->
								<textarea name="plan-description" id="plan-description" maxlength="400" rows="4"> </textarea>
							</div>
							<div class="assessment remove"> 
								<h2> Remove </h2>
								<img src="trash.svg" class="trash" onclick="removeRow(this)"> 
							</div>
						</div>	
						<!-- Row 2 -->
						<div class="plans">
							<div class="assessment weight"> 
								<input type="number" name="weight" min="0" max="100">
							</div>
							<div class="assessment description"> 
								<textarea name="plan-description" id="plan-description" maxlength="400" rows="4"> </textarea>
							</div>
							<div class="assessment remove"> 
								<img src="trash.svg" class="trash"onclick="removeRow(this)"> 
							</div>
						</div>
						<!-- Row 3 -->
						<div class="plans">
							<div class="assessment weight"> 
								<input type="number" name="weight" min="0" max="100">
							</div>
							<div class="assessment description"> 
								<textarea name="plan-description" id="plan-description" maxlength="400" rows="4"> </textarea>
							</div>
							<div class="assessment remove"> 
								<img src="trash.svg" class="trash" onclick="removeRow(this)"> 
							</div>
						</div>
						<!-- Row 4 -->
						<div class="plans">
							<div class="assessment weight"> 
								<input type="number" name="weight" min="0" max="100">
							</div>
							<div class="assessment description"> 
								<textarea name="plan-description" id="plan-description" maxlength="400" rows="4"> </textarea>
							</div>
							<div class="assessment remove"> 
								<img src="trash.svg" class="trash" onclick="removeRow(this)"> 
							</div>
						</div>

<script type="text/javascript">
	function addNew(){
		var node = document.createElement("div");
		node.className = "plans";
		node.innerHTML = " <div class='assessment weight'> <input type='number' name='weight' min='0' max='100'> </div> <div class='assessment description'> <textarea name='plan-description' id='plan-description' maxlength='400' rows='4'> </textarea> </div> <div class='assessment remove'>  <img src='trash.svg' class='trash' onclick='removeRow()'>  </div> ";

		document.getElementById("assessment-plans").appendChild(node);
	}

	function removeRow(el){
		var element = el;
		element.parentNode.parentNode.remove();
	}

	
</script>
						
					</div>

						<div>
							<input type="button" name="add" value="+New" onclick="addNew()"> 
						</div>




					</form>
						<div>
							<input type="submit" value="Save Assessments" id="submit-assessments" onclick="saveAssessment()">
						</div>
					
<script type="text/javascript">
	function saveAssessment(){

		var arr = document.getElementsByName('weight');
	    var tot=0;
	    for(var i=0;i<arr.length;i++){
	        if(parseInt(arr[i].value))
	            tot += parseInt(arr[i].value);
	    }
	    
	    let assessmentMsg = document.getElementById("assessmentMsg");

	    if (tot!=100){
	    	assessmentMsg.style.color = 'red';
	    	assessmentMsg.innerHTML = "assessment weights must add up to 100";
	    	assessmentMsg.style.visibility = "visible";
	    } else {
	    	assessmentMsg.style.visibility = "hidden";
	    }

	    // var arr1 = document.getElementsByName("plan-description");
	    // for (var i=0; i<arr1.length; i++){
	    // 	if (arr1[i].value == ''){
	    // 		assessmentMsg.style.color = 'red';
		   //  	assessmentMsg.innerHTML = "assessment descriptions must not be blank";
		   //  	assessmentMsg.style.visibility = "visible";
		   //  } else {
		   //  	assessmentMsg.style.visibility = "hidden";
		   //  }
	    // }	    
		
		// assessmentMsg.innerHTML = "assessments successfully saved";
		// assessmentMsg.style.visibility = "visible";
		// assessmentMsg.style.color = 'black';
		// setTimeout(function(){document.getElementById("assessmentMsg").style.visibility="hidden";}, 3000);
	}
</script>

					<span id="assessmentMsg"> </span>
					
				</div>
				
				<div class="narratives">
					<h1> Narrative Summary</h1>
					<p> Please enter your narrative for each outcome, including the student strength for the outcome, student weaknesses for the outcome, and suggested action for improving student attainment of each outcome. </p>

					<div id="strengths">
						<h3> Strengths</h3>
						<div class="strength description"> 
							<textarea id="strength" maxlength="2000" rows="4" placeholder="None"></textarea>
						</div>
					</div>

					<div id="weaknesses">
						<h3> Weaknesses </h3>
						<div class="weakness description"> 
							<textarea id="weakness" maxlength="2000" rows="4" placeholder="None"></textarea>
						</div>
					</div>

					<div id="actions">
						<h3> Actions </h3>
						<div class="action description"> 
							<textarea id="action" maxlength="2000" rows="4" placeholder="None"></textarea>
						</div>
					</div>

					<div>
						<input type="submit" value="Save Narrative " id="submit-narratives" onclick="saveNarrative()">
					</div>

<script type="text/javascript">
	function saveNarrative(){
		let narrativeMsg = document.getElementById("narrativeMsg");
		narrativeMsg.style.visibility = "visible";

		setTimeout(function(){document.getElementById("narrativeMsg").style.visibility="hidden";}, 3000);
	}
	
</script>
					<span id="narrativeMsg"> narratives successfully saved </span>
				</div>

			</main>
		</div>

	</body>
</html>