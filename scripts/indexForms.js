var entryForm = null;

/**
* Shows the signup form on page load.
*/
window.onload = function(){
  entryForm = document.getElementById("entryForm");
  showSignUp();
}

/**
* Creates the form users will use for signing up.
*/
function showSignUp(){
  entryForm.innerHTML = "<h2>Sign-Up Today!</h2>" +
  "<form name='signup' action='signup.php' method='post'>" +
    "<div class='form-group'><label for='username'>Username:</label><input class='form-control' type='text' name='username' pattern='^[a-zA-Z0-9\-_ ]{0,30}$' title='A username containing only alphanumerical characters and underscores is required! Max length is 30 characters' required/></div>" +
    "<p style='color=red;' id='passwordMatch'></p>" +
    "<div class='form-group'><label for='password'>Password: </label><input onchange='samePasswordCheck()' class='form-control' type='password' name='password' pattern='^([a-zA-Z1-9\-_]){6,256}$' title='A password containing only alphanumerical characters and underscores  is required! Max length is 256 characters; Min length is 6!' required/></div>" +
    "<div class='form-group'><label for='reenterpassword'>Re-enter Password: </label><input onchange='samePasswordCheck()' class='form-control' type='password' name='reenterPassword' required/></div>" +
    "<div class='form-group'><label for='email'>E-mail: </label><input class='form-control' type='text' name='email' required/></div>" +
    "<div class='form-group'><label for='firstName'>First Name: </label><input class='form-control' type='text' name='firstName' pattern='^([a-zA-Z]){1,30}$' title='First name can only contain alphabetical characters! Max length is 30.' required/></div>" +
    "<div class='form-group'><label for='surname'>Surname: </label><input class='form-control' type='text' name='surname'  pattern='^([a-zA-Z]){1,30}$' title=''Surname can only contain alphabetical characters! Max length is 30.'' required/></div>" +
    "<input id='signUpButton' class='btn btn-success' type='submit' value='Sign Up!'/>" +
  "</form>"
}

/**
* Creates the form users use to sign-in.
*/
function showSignIn(){
  entryForm.innerHTML = "<h2>Sign-In</h2>"+
  "<form action='signin.php' method='post'>" +
  "<div class='form-group'><label for='username'>Username:</label> <input class='form-control' type='text' name='username'/></div>" +
  "<div class='form-group'><label for='password'>Password:</label> <input class='form-control' type='password' name='password'/></div>" +
  "<input class='btn btn-success' type='submit' value='Sign In!'/>" +
  "</form>"
}

/**
* Ensures that the passwords used when signing-up are the same.
* Used for client-side validation.
*/
function samePasswordCheck(){
  if(!(document.forms["signup"]["password"].value == document.forms["signup"]["reenterPassword"].value)){
      console.log("keep on keepin on");
      document.getElementById("passwordMatch").innerHTML = "<p style='color:red;'>Passwords do not match!</p>";
      document.getElementById("signUpButton").disabled = true;
  }

  else if(document.forms["signup"]["password"].value == document.forms["signup"]["reenterPassword"].value){
    document.getElementById("passwordMatch").innerHTML = "";
    document.getElementById("signUpButton").disabled = false;
  }
}
