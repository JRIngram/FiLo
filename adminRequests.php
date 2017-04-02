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
    <h1>Confirm/Decline Requests</h1>
    <?php

      #Checks that user is indeed logged in
      if(isset($_SESSION["username"]) && $_SESSION["category"] == "admin"){
      ?>
        <ul class="list-group">
        <?php
          #Updates the status of an item request if the form as been submitted
          $db = new PDO("mysql:dbname=fifo;host=localhost", "root", "");
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          if(isset($_POST["status"])){
            $statusQuery = $db->prepare("UPDATE itemRequest SET request_status = ? WHERE item_id = ? AND requesting_user = ?");
            $statusQuery->execute(array($_POST["status"], $_POST["itemId"], $_POST["userId"]));
            if($_POST["status"] == "approved"){
              $statusQuery = $db->prepare('UPDATE itemRequest SET request_status = ? WHERE item_id = ? AND requesting_user != ?');
              $statusQuery->execute(array("declined", $_POST["itemId"], $_POST["userId"]));
            }
          }
          #Retrieves all item requests from the DB.
          $requestQuery = $db->prepare('SELECT * FROM itemRequest');
          $requestQuery->execute();
          $requests = array();
          foreach($requestQuery as $request){
            array_push($requests, json_encode($request));
          }
        ?>
        <ul class="list-group">
        <?php
          #Displays all item requests from the DB.
          foreach($requests as $request){
            $requestObj = json_decode($request);
            $itemId = $requestObj->{"item_id"};
            $requestId = $requestObj->{"request_id"};
            $requestStatus = $requestObj->{"request_status"};
            $reason = $requestObj->{"reason"};

            $userQuery = $db->prepare('SELECT username, user_id, email, first_name, last_name FROM user WHERE user_id = ?');
            $userQuery->execute(array($requestObj->{"requesting_user"}));
            $user = array();
            foreach($userQuery as $user){
              $userObj = json_encode($user);
              $user = json_decode($userObj);
            }

          ?>
            <li class="list-group-item">
              <p><b>Details for Request of item #<?= $itemId ?> by <?= $user->{"username"}?>: </b></p>
              <p><b>Status:</b> <?=  $requestStatus ?></p>
              <p><b>Reason:</b> <?= $reason?> </p>
              <p><b>Requester Username:</b> <?= $user->{"username"} ?></p>
              <p><b>Requester E-mail:</b> <?= $user->{"email"} ?></p>
              <p><b>Requester Name:</b> <?= $user->{"first_name"}?> <?= $user->{"last_name"} ?></p>
              <!-- Allows an admin to accept/decline requests -->
              <form method="POST" action="adminRequests.php">
                  <input type="hidden" name="itemId" value="<?= $itemId ?>"/>
                  <input type="hidden" name="userId" value="<?= $user->{"user_id"} ?>"/>
                  <label for="status">Confirm/Decline Request: </label>
                  <select class="form-control"name="status" required>
                    <option value="">Please select... </option>
                    <option value="approved">Confirm</option>
                    <option value="declined">Decline</option>
                  </select>
                  <br/>
                  <input class="btn btn-primary" type="submit" value="Change Status"/>
              </form>
            </li>
        <?php
          }
        ?>
        </ul>
    <?php
      }else{
    ?>
        <h2>Please <a href='index.html'>login</a> as an admin view this page!</h2>
  <?php} ?>
</body>
</html>
