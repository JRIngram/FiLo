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
      if(sha1($pass) == $result["password"]){
          header("Location: itemList.php");
      }
      else{
        echo sha1($pass) . " : " . $result["password"];
        echo "</br>Login failed!";
      }

      session_start();
      $_SESSION["username"]= $username;
      $_SESSION["user_id"] = $result["user_id"];

    }catch(PDOException $ex){
      echo "Error!";
      echo $ex;
    }
  }
  echo $error;
?>
