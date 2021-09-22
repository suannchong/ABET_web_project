// Authenticate email and password
function authenticate(element){
	// Possible 8 Ball responses
   let responses = [ "Without a doubt", "Ask again later", "Don't count on it" ];

   // Display a randomly chosen response
   let randomNum = Math.floor(Math.random() * responses.length);
   document.writeln("<p>Magic 8 Ball says... <strong>" + responses[randomNum] + "</strong>.</p>");


	// $email = $("#email").text();
	// $password = $("#password").text();

	// document.writeIn("<p> Email is " + $email + "</p>");
	// document.writeIn("<p> password is " + $password + "</p>");
	// var req = new XMLHttpRequest();
	// req.open("GET", )
}

// // Possible 8 Ball responses
// let responses = [ "Without a doubt", "Ask again later", "Don't count on it" ];

// // Display a randomly chosen response
// let randomNum = Math.floor(Math.random() * responses.length);
// document.writeln("<p>Magic 8 Ball says... <strong>" + responses[randomNum] + "</strong>.</p>");
