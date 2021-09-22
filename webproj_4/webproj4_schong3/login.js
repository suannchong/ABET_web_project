
// Authenticate email and password
function clickHandler(event){

	event.preventDefault();

	let email = document.getElementById("email").value;
	let password = document.getElementById("password").value;
	let query = "email=" + email + "&password=" + password;

	console.log("login.php?email=" + email + "&password=" + password);

	ajaxreq = new XMLHttpRequest();
	ajaxreq.open("POST", "login.php");
	ajaxreq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxreq.responseType="json";
	ajaxreq.addEventListener("load", login_callback);
	ajaxreq.send(query);
	

}

function login_callback(){

	result = this.response;

	console.log(result);

	if (!result){
		let errMsg = document.getElementById("errorMsg");
		errMsg.style.visibility = "visible";
	} else {
		let errMsg = document.getElementById("errorMsg");
		errMsg.style.visibility = "hidden";
		window.location.assign("abet.php?instructorId="+result);
	}

}
