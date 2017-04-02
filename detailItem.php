<!DOCTYPE html>

<?php
  session_start();
  $addedRequest;
  try{

    $db = new PDO("mysql:dbname=fifo;host=localhost", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    #Adds item request to database
    if(isset($_GET["submitted"])){
      $query = $db->prepare("SELECT * FROM itemRequest WHERE item_id = " . $_GET["itemId"]);
      $query->execute();
      $addRequest = $db->prepare('INSERT INTO itemRequest(item_id, requesting_user, request_status, reason) VALUES(?,?,?,?)');
      $addRequest->execute(array($_GET["itemId"], $_SESSION["user_id"], "waiting", $_GET["reason"]));
      $addedRequest = TRUE;
    }

    $detailedItem = $db->query('SELECT * FROM item WHERE item_id = ' . $_GET["itemId"]);
    $item = $detailedItem->fetch();
  }
  catch(PDOException $ex){
    echo "An error occured: " . $ex;
  }
?>

<html>
  <head>
        <title>FILO</title>
        <link rel="icon" href="images/FILOBaseLogo.png"></link>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.0.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </head>
  <body>
    <?php include('navbar.php'); ?>
    </nav>
    <div class="row" style="margin: auto; width: 1000px">
      <div class="col-md-6">
        <h1>Detailed View of Item <?php  echo $item["item_id"]; ?></h1>
        <?php
          if(isset($_GET["submitted"]) && $addedRequest == "TRUE"){
              echo '<p>Item request sent</p>';
          }
        ?>
        <p><b>Category: </b> <?php echo $item["category"]; ?></p>
        <p><b>Found Date: </b> <?php echo $item["found_date"]; ?></p>
        <p><b>Found Place: </b> <?php echo $item["found_place"]; ?></p>
        <p><b>Main Colour: </b> <?php echo $item["colour"]; ?></p>
        <?php
        #Displays specific details
        if($item["category"] == "pet"){
            #Add Pet details
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
            #Add electronic details
            $electronicDetails = $db->query('SELECT * FROM electronic WHERE item_id = ' . $item["item_id"]);
            $electronic = $electronicDetails->fetch();
        ?>
            <p><b>Electronic Type: </b> <?php echo $electronic["electronicType"] ?></p>
            <p><b>Brand: </b> <?php echo $electronic["brand"] ?></p>
            <p><b>Model: </b> <?php echo $electronic["model"] ?></p>

        <?php
          }
          elseif($item["category"] == "jewellery"){
            #Add jewellery details
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
        <!-- Allows user to request items and give a reason" -->
        <form class="form-group" method="GET" action="detailItem.php">
          <input type="hidden" name="itemId" value="<?php echo $item["item_id"]?>" />
          <input type="hidden" name="submitted" value="true" />
          <div class="form-group">
            <label for="reason">Reason for item request:</label><input title="Characters must be alphabetical, numerical , . ? or !. Must be 140 characters or less." pattern="[A-Za-z0-9,.?! ]{0,140}" class="form-control" type="text" name="reason" required/>
          </div>
          <input class="btn btn-success" type="submit" name="submit" value="Make a claim request"/>
        </form>
      </div>
      <div class="col-md-4">
        <img style="width: 400px; height: 500px" src="<?php echo "uploads/" . $item["photo"]; ?>"/>
      </div>
  </body>
</html>
