
// onload: populate the list of sections on the select input
function requestData(){

	var instructorId = // how to access instructorId on abet.php
	var query = "instructorId=" + instructorId;

	var ajaxreq = new XMLHttpRequest();
	ajaxreq.addEventListener("load", initializeData);
	ajaxreq.open("POST", "section.php");
	ajaxreq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxreq.responseType="json";
	ajaxreq.send(query);
}

function initalizeData(){
	var result = this.response;
	var sectionObj;

	// populate the right sections for a given instructorId 
	for (sectionObj of result){
		var child = document.createElement("option");
		child.innerHTML = sectionObj['sectionId'] + sectionObj['courseId'] + sectionObj['major'] + sectionObj['year'];
		document.getElementById("sections").append(child);
	}
}

function sectionSelectHandler(event){
	event.preventDefault();


}