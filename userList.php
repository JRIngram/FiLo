<!DOCTYPE html>
<html>
  <head>
        <title>FIFO</title>
        <link rel="icon" href="images/FILOBaseLogo.png"></link>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.0.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </head>
  <body>
    <?php
      session_start();
      include('navbar.php');
    ?>
      <div style="width: 500px; margin: auto">
        <h1>Users</h1>
        <?php

          #Checks that user is indeed logged in
          if(isset($_SESSION["category"]) && $_SESSION["category"] == "admin"){
            try{
                $db = new PDO("mysql:dbname=fifo;host=localhost", "root", "");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                if(isset($_POST["userId"])){
                  $categoryQuery = $db->prepare("UPDATE user SET user_type = ? WHERE user_id = ?");
                  $categoryQuery->execute(array($_POST["category"], str_replace("'", "", $_POST["userId"])));
                  ?> <p style="color: green;">User category successfully updated</p> <?php
                }
                $userQuery = $db->query("SELECT * FROM user WHERE username != \"" . str_replace("'", "", $_SESSION["username"]) . "\"");
                $users = array();
                foreach ($userQuery as $user){
                  array_push($users, json_encode($user));
              }
          ?>
          <!--Displays the list of all users-->
          <ul class="list-group">
            <?php
              foreach($users as $user){
                $userObj = json_decode($user);
                $username = $userObj->{"username"};
                $userId = $userObj->{"user_id"};
                $forename = $userObj->{"first_name"};
                $surname = $userObj->{"last_name"};
                $email = $userObj->{"email"};
                $category = $userObj->{"user_type"};
            ?>
              <li class="list-group-item">
                <?php
                  echo "<p><b>ID: " . $userId . " - " . $username . ": </b></p>";
                  echo "<p><b>Name:</b> " . $forename . " " . $surname . "</p>";
                  echo "<p><b>Email: </b>" . $email . "</p>";
                  echo "<p><b>Category: </b>" . $category . "</p>";
                ?>
                <!--Admin can change the category of user, from registered to admin-->
                <form method="POST" action="users.php"/>
                  <label for="category"/>New user category:</label>
                  <select class="form-control" name="category" required>
                    <option value="">Please select... </option>
                    <option value="registered">Normal User</option>
                    <option value="admin">Admin User</option>
                  </select>
                  <br/>
                  <input type="hidden" name="userId" value="<?php echo $userObj->{'user_id'} ?>" />
                  <input type="submit" class="btn btn-success" value="Change user category"/>
                </form>
              </li>
            <?php
              }
            ?>
          </ul>
          <?php
        }catch(PDOException $ex){
          echo "An error has occured!: " . $ex;
        }

      }

      #If user not logged in they cannot add an item.
      else{
      ?>
        <h2>Please <a href="index.html">login</a> as an admin to view this page!</h2>
      <?php
        }
      ?>
    </div>
  </body>
</html>
