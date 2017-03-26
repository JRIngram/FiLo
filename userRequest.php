<head>
      <meta charset="utf-8"/>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.0.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
  <nav class="navbar navbar-default">
    <ul class="nav navbar-nav">
      <li><a href="../signOut.php">Sign-Out</a></li>
      <li ><a href="../itemList.php">View Items</a></li>
      <li><a href="../addItem.php">Add Item</a></li>
    </ul>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <?php
      session_start();
      if(isset($_SESSION["category"]) && $_SESSION["category"] == "admin"){
      ?>

        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="users.php">Users</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="requests.php">Requests</a></li>
            </ul>
          </li>
        </ul>
      <?php
      }
      ?>
    </nav>
    <div style="width: 500px; margin: auto">
      <h1><?= str_replace("'", "", $_SESSION["username"]) ?>'s requests</h1>
      <?php
        #Checks that user is indeed logged in
        if(isset($_SESSION["username"])){
          try{
              $db = new PDO("mysql:dbname=fifo;host=localhost", "root", "");
              $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $requestQuery = $db->prepare('SELECT * FROM itemRequest WHERE requesting_user = ?');
              $requestQuery->execute(array($_SESSION["user_id"]));
              $requests = array();
              foreach($requestQuery as $request){
                array_push($requests, json_encode($request));
              }
        ?>
          <ul class="list-group">
            <?php
              foreach($requests as $request){
                $requestObj = json_decode($request);
                $itemId = $requestObj->{"item_id"};
                $requestId = $requestObj->{"request_id"};
                $requestStatus = $requestObj->{"request_status"};
                $reason = $requestObj->{"reason"};

                ?>
                  <li class="list-group-item">
                    <p><b>Details for Request of item #<?= $itemId ?>: </b></p>
                    <p>Status: <?=  $requestStatus?></p>
                    <p>Reason: <?= $reason?> </p>
                  </li>
              }
          </ul>
        <?php
          }catch(PDOException $ex){
              echo "An error has occured!: " . $ex;
          }


          #If user not logged in they cannot add an item.
    }else{
        ?>
        <h2>Please <a href="index.html">login</a> to view this page!</h2>
    <?= } ?>
  </div>
</body>
</html>
