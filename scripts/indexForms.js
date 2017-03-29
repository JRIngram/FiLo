var entryForm = null;

window.onload = function(){
  entryForm = document.getElementById("entryForm");
  showSignUp();
}

function showSignUp(){
  entryForm.innerHTML = "<h2>Sign-Up Today!</h2>" +
  "<form action='signup.php' method='post'>" +
    "<div class='form-group'><label for='username'>Username:</label><input class='form-control' type='text' name='username' required/></div>" +
    "<div class='form-group'><label for='password'>Password: </label><input class='form-control' type='password' name='password' required/></div>" +
    <!--Add another password field for validation: reenter password ect.-->
    <!--Add something which ensures unique emails-->
    "<div class='form-group'><label for='email'>E-mail: </label><input class='form-control' type='text' name='email' required/></div>" +
    "<div class='form-group'><label for='firstName'>First Name: </label><input class='form-control' type='text' name='firstName' required/></div>" +
    "<div class='form-group'><label for='surname'>Surname: </label><input class='form-control' type='text' name='surname' required/></div>" +
    "<input class='btn btn-success' type='submit' value='Sign Up!'/>" +
  "</form>"
}

function showSignIn(){
  entryForm.innerHTML = "<h2>Sign-In</h2>"+
  "<form action='signin.php' method='post'>" +
  "<div class='form-group'><label for='username'>Username:</label> <input class='form-control' type='text' name='username'/></div>" +
  "<div class='form-group'><label for='password'>Password:</label> <input class='form-control' type='password' name='password'/></div>" +
  "<input class='btn btn-success' type='submit' value='Sign In!'/>" +
  "</form>"
}
