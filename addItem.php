<!DOCTYPE html>
<html>
  <head>
    <title>FILO</title>
    <link rel="icon" href="images/FILOBaseLogo.png"></link>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"></link>
    <meta charset="utf-8"/>
    <script src="https://code.jquery.com/jquery-3.2.0.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="scripts/addItem.js"></script>
  </head>
  <body>
      <?php
        session_start();
        $success = FALSE;
        if(isset($_POST["submitted"])){
          #Validates inputs
          if((preg_match("/^[0-9]{4}\-[0-1]*[0-9]\-[0-3]*[0-9]$/", $_POST["date_found"]))
            && (preg_match("/^[0-9]{1,3}$/", $_SESSION["user_id"]))
            && (preg_match("/^([0-9a-zA-Z\- !]){1,100}$/", $_POST["found_place"]))
            && (preg_match("/^[a-zA-Z ]{0,20}$/", $_POST["colour"]))
            && (preg_match("/^([a-zA-Z0-9,\.!?\-\"'\\ ]){0,100}$/", $_POST["description"]))
            && ($_POST["category"] == "jewellery" || $_POST["category"] == "electronic" || $_POST["category"] == "pet")
            && (isset($_FILES["photo"]))
          ){
            try{
              #Uploads photo
              $photoName = date('Y-m-d') . "_" . date('h-i-s') . "_" . $_SESSION["user_id"] . "_" . $_FILES["photo"]["name"];
              if(!is_dir("uploads")){
                mkdir("uploads");

                chown("uploads", "daemon");
                chmod("uploads", 765);
              }
              move_uploaded_file($_FILES["photo"]["tmp_name"], "uploads/" . $photoName);

              #Uploads item to DB
              $db = new PDO("mysql:dbname=fifo;host=localhost", "root", "");
              $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $itemQuery = $db->prepare('INSERT INTO item(category, found_date, found_user, found_place, colour, photo, description) VALUES(
                      ?, ?, ?, ?, ?, ?, ?)');
              $itemQuery->execute(array($_POST["category"], $_POST["date_found"], $_SESSION["user_id"], $_POST["found_place"], $_POST["colour"], $photoName, $_POST["description"]));
              $idQuery = $db->prepare('SELECT MAX(item_id) AS item_id, found_user FROM item WHERE found_user = ' . $_SESSION["user_id"]);
              $idQuery->execute();
              $recentlyAddedId = $idQuery->fetch();
              $recentlyAddedId = $recentlyAddedId["item_id"];

              #Validates inputs for jewellery items
              if($_POST["category"] == "jewellery"){
                if(isset($_POST["metalType"])
                && isset($_POST["jewelleryType"])
                && preg_match("/^[a-zA-Z ]{0,20}$/", $_POST["metalType"])
                && preg_match("/(necklace)|(bracelet)|(ring)|(ear-ring)|(other)/", $_POST["jewelleryType"])){
                  $jewelleryQuery = $db->prepare('INSERT INTO jewellery(item_id, metal, jewellery_type) VALUES(?,?,?)');
                  $jewelleryQuery->execute(array($recentlyAddedId, $_POST["metalType"], $_POST["jewelleryType"]));
                  $success = TRUE;
                }
              }

              #Validates inputs for electronic items
              if($_POST["category"] == "electronic"){
                if(isset($_POST["electronicType"])
                && isset($_POST["brand"])
                && isset($_POST["model"])
                && preg_match("/^[a-zA-Z ]{0,60}$/", $_POST["electronicType"])
                && preg_match("/^[a-zA-Z0-9 ]{0,20}$/", $_POST["brand"])
                && preg_match("/^[a-zA-Z0-9 ]{0,20}$/", $_POST["model"])){
                  $electronicQuery = $db->prepare('INSERT INTO electronic(item_id, electronicType, brand, model) VALUES(?,?,?,?)');
                  $electronicQuery->execute(array($recentlyAddedId, $_POST["electronicType"], $_POST["brand"], $_POST["model"]));
                  $success = TRUE;
                }
              }

              #Validates inputs for pet items
              if($_POST["category"] == "pet"){
                if(isset($_POST["pet_name"])
                && isset($_POST["animal"])
                && isset($_POST["breed"])
                && isset($_POST["collar_colour"])
                && preg_match("/^[a-zA-Z ]{0,30}$/", $_POST["pet_name"])
                && preg_match("/^[a-zA-Z ]{0,40}$/", $_POST["animal"])
                && preg_match("/^[a-zA-Z ]{0,30}$/", $_POST["breed"])
                && preg_match("/^[a-zA-Z ]{0,20}$/", $_POST["collar_colour"])){
                  $petQuery = $db->prepare('INSERT INTO pet(item_id, pet_name, breed, collar_colour, animal) VALUES (?,?,?,?,?)');
                  $petQuery->execute(array($recentlyAddedId, $_POST["pet_name"], $_POST["breed"], $_POST["collar_colour"], $_POST["animal"]));
                  $success = TRUE;
                }
              }
            }

            catch(PDOException $ex){
              echo "An error occured!: " . $ex;
            }
          }
        }
        include('navbar.php');
    ?>
      <div style="width: 500px; margin: auto">
        <h1>Add an item</h1>
        <?php

        #Checks that user is indeed logged in
        if(isset($_SESSION["username"])){
          if($success == TRUE){
            echo "<p>Item added successfully!</p>";
          }
          else if ($success == FALSE && isset($_POST["submitted"])){
            echo "<p>Error adding item!</p>";
            if(!(preg_match("/^[0-9]{4}\-[0-1]*[0-9]\-[0-3]*[0-9]$/", $_POST["date_found"]))){
              echo "Date must be written in yyyy-dd-mm format";
            }
          }
        ?>

        <!--Form for adding items -->
        <form id="addItemForm" action="addItem.php" method="POST" enctype="multipart/form-data">
          <!--Input for category-->
          <div class="form-group">
            <label for="category">Category: </label>
            <select class="form-control" id="category" name="category" onchange="updateAddItemForm()" required>
                <option value="">Please Select...</option>
                <option value="electronic">Electronic</option>
                <option value="jewellery">Jewellery</option>
                <option value="pet">Pet</option>
            </select>
          </div>

          <!-- Date the item was found -->
          <div class="form-group">
            <label for="found_date">Found Date <i>(dd/mm/yyyy)</i>: </label>
            <input id="found_date" type="date" name="date_found" min="1900-01-01" pattern="^[0-9]{4}\-[0-1]*[0-9]\-[0-3]*[0-9]$" title="Please enter a valid date" required="true"/>
          </div>

          <!--Input for found place-->
          <div class="form-group">
            <label for="found_place">Found Place <i>(City)</i>:</label>
            <input class="form-control" type="text" name="found_place" pattern="^([0-9a-zA-Z\- !]){1,100}$" title="Please enter a place containing only alphanumerical characters, \ - spaces and !. It must be less than 100 characters in length." required="true"/>
          </div>

          <!--Input for main colour of object-->
          <div class="form-group">
            <label for="colour">Main Colour of Object:</label>
            <input class="form-control" type="text" name="colour" pattern="^[a-zA-Z ]{0,20}$" title="Please enter only alphabetical characters and spaces. Colour must be less than 20 characters." required="true"/>
          </div>

          <!--Description of the object-->
          <div class="form-group">
            <label for="description">Description: </label>
            </br>
            <input class="form-control" name="description" pattern="^([0-9a-zA-Z\.,\- !]){1,100}$" title="Please enter a place containing only alphanumerical characters, \ - spaces and !. It must be less than 100 characters in length." required="true" />
          </div>

          <!-- Asks user to upload image -->
          <label for="photo">Upload a photo:</label>
          <input type="file" name="photo" accept="image/*" pattern="^([0-9a-zA-Z\(\)]){1,73}$" required="true" required="true"/>
          <p class="help-block">Should be of type gif, png or jpeg</p>
          <span id="specificQuestions"></span>

          <!--Allows server to check that the form has been submitted-->
          <input type="hidden" name="submitted" value="true"/>
          <input  class="btn btn-success" type="submit" name="submit" value="Add Item"/>
        </form>
        <?php
        }

        #If user not logged in they cannot add an item.
        else{
        ?>
          <h2>Please <a href="index.html">login</a> to add an item</h2>
        <?php
          }
        ?>
      </div>
  </body>
</html>
