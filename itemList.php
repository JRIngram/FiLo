<!DOCTYPE html>

<?php
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
        <li><a href="index.html">Sign-Out</a></li>
        <li class="active"><a href="#">View Items</a></li>
        <li><a href="addItem.php">Add Item</a></li>
        <li class="dropdown">
           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
           <ul class="dropdown-menu">
             <li><a href="#">View All Items</a></li>
             <li role="separator" class="divider"></li>
             <li><a href="#">View Electronics</a></li>
             <li><a href="#">View Jewellery</a></li>
             <li><a href="#">View Pets</a></li>
           </ul>
         </li>
      </ul>
    </nav>
    <div class="page-header"><h1>MAIN PAGE <small> - Please login to see more details</small></h1></div>
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
      <ul class="list-group">
      <?php
        foreach($items as $item){
          $itemObj = json_decode($item);
      ?>
          <li class="list-group-item">
            <p><b>Basic details for Item <?php echo $itemObj->{"item_id"} ?>: </b></p>
            <p><?php echo $itemObj->{"found_date"} . ", " . $itemObj->{"found_place"} . ", " . $itemObj->{"category"}?>.</p>
          </li>
      <?php
        }
      ?>
    </ul>
  </body>
</html>
