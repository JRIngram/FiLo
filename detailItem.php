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
        <?php
          #Creates specific questions.
          if($item["category"] == "pet"){
            #Add Pet questions
            $petDetails = $db->query('SELECT * FROM pet WHERE item_id = ' . $item["item_id"]);
            $pet = $petDetails->fetch();
        ?>
        <p><b>Animal: </b> <?php echo $pet["animal"]?></p>
        <p><b>Pet Name: </b> <?php echo $pet["pet_name"] ?></p>
        <p><b>Breed: </b> <?php echo $pet["breed"] ?></p>
        <p><b>Collar Colour: </b> <?php echo $pet["collar_colour"]?></p>

        <?php
          }
          elseif($item["category"] == "electronic"){
            #Add electronic questions
            $electronicDetails = $db->query('SELECT * FROM electronic WHERE item_id = ' . $item["item_id"]);
            $electronic = $electronicDetails->fetch();
        ?>
        <p><b>Electronic Type: </b> <?php echo $electronic["electronicType"] ?></p>
        <p><b>Brand: </b> <?php echo $electronic["brand"] ?></p>
        <p><b>Model: </b> <?php echo $electronic["model"] ?></p>

        <?php
          }
          elseif($item["category"] == "jewellery"){
            #Add jewellery questions
            $jewelleryDetails = $db->query('SELECT * FROM jewellery WHERE item_id = ' . $item["item_id"]);
            $jewellery = $jewelleryDetails->fetch();
        ?>
        <p><b>Metal: </b><?php echo $jewellery["metal"] ?></p>
        <p><b>Jewellery Type: </b><?php echo $jewellery["jewellery_type"] ?></p>
        <?php
          }
          else{
            echo "<p><b>ERROR</b>Invalid Item Type</p>";
          }
        ?>
        <p><b>Description: <br/></b><p> <?php echo $item["description"] ?></p>
      </div>
      <div class="col-md-4">
        <img style="width: 400px; height: 500px" src="<?php echo "uploads/" . $item["photo"]; ?>"/>
      </div>
  </body>
</html>
