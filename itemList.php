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
    <h1>MAIN PAGE</h1>

  </body>
</html>
