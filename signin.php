<?php
  $error = "";
  if($_POST["username"] == NULL || $_POST["password"] == NULL){
    $error = "Please enter both a Username and Password";
  }
  else{
    try{
      $db = new PDO("mysql:dbname=fifo;host=localhost", "root", "");
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $username = $db->quote($_POST["username"]);
      $pass = $_POST["password"];
      $query = $db->prepare("SELECT * FROM user WHERE username = " . $username);
      $query->execute();
      $result = $query->fetch();
      if(hash("sha256", $_POST["password"]) == $result["password"]){
          header("Location: itemList.php");
      }
      else{
        echo "<p style='color: red;'>Username and password do not match!</p>";
        include("index.html");
      }

      session_start();
      $_SESSION["username"] = $username;
      $_SESSION["user_id"] = $result["user_id"];
      $_SESSION["category"] =  $result["user_type"];

    }catch(PDOException $ex){
      echo "Error!";
      echo $ex;
    }
  }
  echo $error;
?>
