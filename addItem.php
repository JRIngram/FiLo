<!DOCTYPE>
<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"></link>
    <meta charset="utf-8"/>
    <script src="https://code.jquery.com/jquery-3.2.0.min.js" integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script>
    /**
    * Adds specific questions for the different item categories on the open categories page
    */
    function updateAddItemForm(){
      var specificQuestions = document.getElementById("specificQuestions");
      var categoryDropdown = document.getElementById("category");
      var categoryValue = categoryDropdown.value;

      //Adds unique questions for found phones.
      if(categoryValue == "electronic"){
        var electronicQuestions = '<div class="form-group"><label for="electronicType">Type of Electronic: </label><input class="form-control" type="text" name="electronicType"/></div>' +
        '<div class="form-group"><label for="brand">Brand: </label><input class="form-control" type="text" name="brand"/></div>' +
        '<div class="form-group"><label for="model">Model: </label><input class="form-control" type="text" name="model"/></div>';
        specificQuestions.innerHTML = electronicQuestions;
      }

      //Adds unique questions for found jewellery.
      else if(categoryValue == "jewellery"){
        var jewelleryQuestions = '<div class="form-group"><label for="metalType">Metal Type:</label><input class="form-control" type="text" name="metalType"/></div>' +
        '<div class="form-group"><label for="jewelleryType">Jewellery Type: </label><input class="form-control" type="text" name="jewelleryType"/></div>';
        specificQuestions.innerHTML = jewelleryQuestions;
      }

      //Adds unique questions for found pets.
      else if(categoryValue == "pet"){
        var petQuestions = '<div class="form-group"><label for="pet_name">Pet Name:</label><input class="form-control" type="text" name="pet_name"/></div>' +
        '<div class="form-group"><label for="animal">Animal: </label><input class="form-control" type="text" name="animal"/></div>' +
        '<div class="form-group"><label for="breed">Breed: </label><input class="form-control" type="text" name="breed"/></div>' +
        '<div class="form-group"><label for="collar_colour">Collar Colour: </label><input class="form-control" type="text" name="collar_colour"/><br/>';
        specificQuestions.innerHTML = petQuestions;
      }

      else{
        specificQuestions.innerHTML = "";
      }
    }
    </script>
  </head>
  <body>
      <?php
        session_start();

        $success = FALSE;
        if(isset($_POST["submitted"])){
          $found_date = $_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"];
          #Validates inputs
          if((preg_match("/^[0-9]{4}\-[0-1]*[0-9]\-[0-3]*[0-9]$/", $found_date))
            && (preg_match("/^[0-9]{1,3}$/", $_SESSION["user_id"]))
            && (preg_match("/^([0-9a-zA-Z\- !]){1,100}$/", $_POST["found_place"]))
            && (preg_match("/^[a-zA-Z ]{0,20}$/", $_POST["colour"]))
            && (preg_match("/^([a-zA-Z0-9,.!?\-\"'\\ ]){0,100}$/", $_POST["description"]))
            && ($_POST["category"] == "jewellery" || $_POST["category"] == "electronic" || $_POST["category"] == "pet")
          ){
            try{
              #Uploads photo
              $photoName = date('Y-m-d') . "_" . date('h:i:s') . "_" . $_SESSION["user_id"] . "_" . $_FILES["photo"]["name"];
              if(!is_dir("uploads")){
                mkdir("uploads");
                /*FIX FOR LOCALHOST*/
                chown("uploads", "daemon");
                chmod("uploads", 765);
              }
              move_uploaded_file($_FILES["photo"]["tmp_name"], "uploads/" . $photoName);

              $db = new PDO("mysql:dbname=fifo;host=localhost", "root", "");
              $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $itemQuery = $db->prepare('INSERT INTO item(category, found_date, found_user, found_place, colour, photo, description) VALUES(
                      ?, ?, ?, ?, ?, ?, ?)');
              $itemQuery->execute(array($_POST["category"], $found_date, $_SESSION["user_id"], $_POST["found_place"], $_POST["colour"], $photoName, $_POST["description"]));

              $idQuery = $db->prepare('SELECT MAX(item_id) AS item_id, found_user FROM item WHERE found_user = ' . $_SESSION["user_id"]);
              $idQuery->execute();
              $recentlyAddedId = $idQuery->fetch();
              $recentlyAddedId = $recentlyAddedId["item_id"];

              if($_POST["category"] == "jewellery"){
                $jewelleryQuery = $db->prepare('INSERT INTO jewellery(item_id, metal, jewellery_type) VALUES(?,?,?)');
                $jewelleryQuery->execute(array($recentlyAddedId, $_POST["metalType"], $_POST["jewelleryType"]));
              }

              if($_POST["category"] == "electronic"){
                $phoneQuery = $db->prepare('INSERT INTO electronic(item_id, electronicType, brand, model) VALUES(?,?,?,?)');
                $phoneQuery->execute(array($recentlyAddedId, $_POST["electronicType"], $_POST["brand"], $_POST["model"]));
              }

              if($_POST["category"] == "pet"){
                $petQuery = $db->prepare('INSERT INTO pet(item_id, pet_name, breed, collar_colour, animal) VALUES (?,?,?,?,?)');
                $petQuery->execute(array($recentlyAddedId, $_POST["pet_name"], $_POST["breed"], $_POST["collar_colour"], $_POST["animal"]));
              }
              $success = TRUE;
            }
            catch(PDOException $ex){
              echo "An error occured!: " . $ex;
            }
          }
        }
      ?>
      <nav class="navbar navbar-default">
        <ul class="nav navbar-nav">
          <li><a href="signOut.php">Sign-Out</a></li>
          <li><a href="itemList.php">View Items</a></li>
          <li class="active"><a href="#">Add Item</a></li>
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
          }
        ?>
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
          <div class="form-group">
            <label for="found_date">Found Date <i>(dd/mm/yyyy)</i>: </label>
            <br/>
            <select name="day" required>
              <?php
                for($i = 1; $i <= 31; $i++){
              ?>
                  <option value="<?= $i ?>"><?= $i ?></option>
              <?php
                }
              ?>
            </select>
            <select name="month" required>
              <?php
                for($i = 1; $i <= 12; $i++){
              ?>
                  <option value="<?= $i ?>"><?= $i ?></option>
              <?php
                }
              ?>
            </select>
            <select name="year" required>
              <?php
                $currentYear = date("Y");
                for($i = $currentYear; $i >= 1900; $i--){
              ?>
                  <option value="<?= $i ?>"><?= $i ?></option>
              <?php
                }
              ?>
            </select>
          </div>

          <!--Input for found place-->
          <div class="form-group">
            <label for="found_place">Found Place <i>(City)</i>:</label>
            <input class="form-control" type="text" name="found_place" required/>
          </div>

          <!--Input for main colour of object-->
          <div class="form-group">
            <label for="colour">Main Colour of Object:</label>
            <input class="form-control" type="text" name="colour"/>
          </div>

          <div class="form-group">
            <label for="description">Description: </label>
            </br>
            <textarea class="form-control" name="description" rows="2" cols="25"></textarea>
          </div>

          <label for="photo">Upload a photo:</label>
          <input type="file" name="photo" accept="image/*" />
          <p class="help-block">Should be of type gif, png or jpeg</p>
          <span id="specificQuestions"></span>

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
