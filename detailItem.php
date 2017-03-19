<!DOCTYPE html>
<?php
  $db = new PDO("mysql:dbname=fifo;host=localhost", "root", "");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $detailedItem = $db->query('SELECT * FROM item WHERE item_id = ' . $_GET["itemId"]);
  $item = $detailedItem->fetch();
?>

<html>
  <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-default">
      <ul class="nav navbar-nav">
        <li><a href="signOut.php">Sign-Out</a></li>
        <li><a href="itemList.php">View Items</a></li>
        <li><a href="addItem.php">Add Item</a></li>
    </nav>
    <div class="row" style="margin: auto; width: 1000px">
      <div class="col-md-6">
        <h1>Detailed View of Item <?php  echo $item["item_id"]; ?></h1>
        <p><b>Category: </b> <?php echo $item["category"]; ?></p>
        <p><b>Found Date: </b> <?php echo $item["found_date"]; ?></p>
        <p><b>Found Place: </b> <?php echo $item["found_place"]; ?></p>
        <p><b>Main Colour: </b> <?php echo $item["colour"]; ?></p>
        <p><b>Description: <br/></b><p> <?php echo $item["description"] ?></p>
      </div>
      <div class="col-md-4">
        <img style="width: 400px; height: 500px" src="<?php echo "uploads/" . $item["photo"]; ?>"/>
      </div>
  </body>
</html>
