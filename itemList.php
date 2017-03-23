<!DOCTYPE html>

<?php
  session_start();
  $db = new PDO("mysql:dbname=fifo;host=localhost", "root", "");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $itemQuery = $db->query('SELECT * FROM item');
  $items = array();
  foreach ($itemQuery as $item){
    array_push($items, json_encode($item));
  }
?>

<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"></link>
    <meta charset="utf-8"/>
    <script src="https://code.jquery.com/jquery-3.2.0.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </head>
  <body>
    <nav class="navbar navbar-default">
      <ul class="nav navbar-nav">
        <li><a href="signOut.php">Sign-Out</a></li>
        <li class="active"><a href="#">View Items</a></li>
        <li><a href="addItem.php">Add Item</a></li>
      </ul>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <?php
        if(isset($_SESSION["category"]) && $_SESSION["category"] == "admin"){
      ?>

        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="admin/users.php">Users</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="admin/requests.php">Requests</a></li>
            </ul>
          </li>
        </ul>
      <?php
        }
      ?>
    </nav>
    <div class="page-header">
      <h1>MAIN PAGE
        <?php
          if(!isset($_SESSION["username"])){
      ?>
            <small> - Please <a href="index.html">login</a> to see more details</small>
      <?php } ?>
      </h1>
    </div>
        <?php
        if(isset($_SESSION["username"])){
          ?>
          <div class="row">
            <div class="col-md-2" style="margin: auto">
              <label for="category">Select category to browse by:</label>
              <select class="form-control" id="category" name="category" onchange="updateAddItemForm()" required>
                <option value="">View all Items</option>
                <option value="electronic">Electronic</option>
                <option value="jewellery">Jewellery</option>
                <option value="pet">Pet</option>
              </select>
            </div>
         </div>
        <?php
        }
        ?>
      <ul class="list-group">
      <?php
        foreach($items as $item){
          $itemObj = json_decode($item);
          $itemId = $itemObj->{"item_id"};
      ?>
          <li class="list-group-item">
            <p><b>Basic details for Item <?php echo $itemId ?>: </b></p>
            <p><?php echo $itemObj->{"found_date"} . ", " . $itemObj->{"found_place"} . ", " . $itemObj->{"category"}?>.</p>
            <?php
              if(isset($_SESSION["username"])){
            ?>
                <form method="GET" action="detailItem.php">
                  <input type="hidden" name="itemId" value="<?php echo $itemObj->{'item_id'} ?>" />
                  <input class="btn btn-info" type="submit" value="More Detail" name="submit"/>
                </form>
            <?php
              }
            ?>
          </li>
      <?php
        }
      ?>
    </ul>
  </body>
</html>
