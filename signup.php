<?php
    $error = "";
    if(!preg_match("/^([a-zA-Z1-9\-_]){1,30}$/", $_POST["username"])){
      $error = $error . "<p  style='color: red;' >A username containing only the characters 'a-z', 'A-Z', '0-9', '-' and '_' is required! Max length is 30 characters</p>";
    }

    if(!preg_match("/^([a-zA-Z1-9-_]){6,256}$/", $_POST["password"])){
      $error = $error . "<p  style='color: red;'>A password containing only the characters 'a-z', 'A-Z', '0-9', '-' and '_' is required! Max length is 256 characters; Min length is 6!</p>";
    }

    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
      $error .= "<p  style='color: red;'>Your e-mail is not valid!</p>";
    }

    if(!preg_match("/^([a-zA-Z]){1,30}$/", $_POST["firstName"])){
      $error = $error . "<p  style='color: red;'>Your first name is required! Max length is 30.</p>";
    }

    if(!preg_match("/^([a-zA-Z]){1,30}$/", $_POST["surname"])){
      $error = $error . "<p  style='color: red;'>Your surname is required! Max length is 30.</p>";
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
      echo "<p style='color: red;'>" . $error . "</p>";
      include("index.html");
    }
?>
