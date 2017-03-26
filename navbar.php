<nav class="navbar navbar-default">
  <ul class="nav navbar-nav">
    <li><a href="signOut.php">Sign-Out</a></li>
    <li ><a href="itemList.php">View Items</a></li>
    <li><a href="addItem.php">Add Item</a></li>
  </ul>
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  <?php
    if(isset($_SESSION["category"]) && $_SESSION["category"] == "admin"){
    ?>
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="userList.php">Users</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="adminRequests.php">Requests</a></li>
          </ul>
        </li>
      </ul>
    <?php
    }
    ?>
  </nav>
