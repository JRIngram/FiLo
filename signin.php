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
      #SELECT password FROM user WHERE username = $username;
      #$rows = $db->query("SELECT password FROM user WHERE username = " . $username);
      $query = $db->prepare("SELECT password FROM user WHERE username = " . $username);
      $query->execute();
      $result = $query->fetch();
      if(sha1($pass) == $result["password"]){
          echo "YOU SIGNED IN!</br>";
          echo sha1($pass) . " : " . $result["password"];
      }
      else{
        echo sha1($pass) . " : " . $result["password"];
        echo "</br>Login failed!";
      }

    }catch(PDOException $ex){
      echo "Error!";
      echo $ex;
    }
  }
  echo $error;
?>
