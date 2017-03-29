<?php
    $error = "";
    if(!preg_match("/^([a-zA-Z1-9-_]){1,30}$/", $_POST["username"])){
      $error = $error . "<p>A username containing only the characters 'a-z', 'A-Z', '0-9', '-' and '_' is required! Max length is 30 characters</p>";
    }

    if(!preg_match("/^([a-zA-Z1-9-_]){1,64}$/", $_POST["password"])){
      $error = $error . "<p>A password containing only the characters 'a-z', 'A-Z', '0-9', '-' and '_' is required! Max length is 64 characters!</p>";
    }

    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
      $error .= "<p>Your e-mail is not valid!</p>";
    }

    if(!preg_match("/^([a-zA-Z1-9]){1,30}$/", $_POST["firstName"])){
      $error = $error . "<p>Your first name is required! Max length is 30.</p>";
    }

    if(!preg_match("/^([a-zA-Z1-9 ]){1,30}$/", $_POST["surname"])){
      $error = $error . "<p>Your surname is required! Max length is 30.</p>";
    }



    if($error == ""){
      $usertype = "registered";
      try{
        $db = new PDO("mysql:dbname=fifo;host=localhost", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $username = strtolower($_POST["username"]);
        $pass = hash("sha256", $_POST["password"]);
        $email = $_POST["email"];
        $firstname = $_POST["firstName"];
        $surname = $_POST["surname"];
        $sql = $db->prepare('INSERT INTO user(username, password, user_type, first_name, last_name, email) VALUES(
          ?, ?, ?, ?, ?, ?)');
        $sql->execute(array($username, $pass, $usertype, $firstname, $surname, $email));
        ?>
        <p style:"colour: green;">Thanks for signing up <?= $username?>!</p>
        <?php
            }catch(PDOException $ex){
              echo "An error occurred!";
              echo $ex;
            }
    }
    else{
      ?>
      <!DOCTYPE>
      <html>
        <head>
          <title>FIFO</title>
          <link rel="icon" href="images/FILOBaseLogo.png"></link>
          <link rel="stylesheet" type="text/css" href="styles/homepage.css"></link>
        </head>
        <body>

          <h1>FILo | <i>Find The Lost</i></h1>

          <div id="logo">
            <img src="images/FILOBaseLogo.png"/>
          </div>

          <main class="forms">

            <div id="sign-up" style="display:inline;">
              <h2>Sign-Up Today!</h2>
              <p> <?= $error ?></p>
              <form action="signup.php" method="post">
                <p>Username: <input type="text" name="username" required/></p>
                <p>Password: <input type="password" name="password" required/></p>
                <p>E-mail: <input type="text" name="email" required/></p>
                <p>First Name: <input type="text" name="firstName" required/></p>
                <p>Surname: <input type="text" name="surname" required/></p>
                <input type="submit" value="Sign Up!"/>
              </form>
            </div>

            <div id="sign-in" style="display:inline">
              <h2>Sign-In</h2>
              <form action="signin.php" method="post">
                <p>Username: <input type="text" name="username"/></p>
                <p>Password: <input type="password" name="password"/></p>
                <input type="submit" value="Sign In!"/>
              </form>
            </div>
          </main>

        </body>
      </html>
<?php
    }
?>
