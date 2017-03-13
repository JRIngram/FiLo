<!DOCTYPE>
<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script>
    /**
    * Adds specific questions for the different item categories on the open categories page
    */
    function updateAddItemForm(){
      var specificQuestions = document.getElementById("specificQuestions");
      var categoryDropdown = document.getElementById("category");
      var categoryValue = categoryDropdown.value;

      //Adds unique questions for found phones.
      if(categoryValue == "phone"){
        var phoneQuestions = '<label for="brand">Phone brand: </label><input type="text" name="brand"/><br/>';
        phoneQuestions += '<label for="model">Phone model: </label><input type="text" name="model"/><br/>';
        specificQuestions.innerHTML = phoneQuestions;
      }

      //Adds unique questions for found jewellery.
      else if(categoryValue == "jewellery"){
        var jewelleryQuestions = '<label for="metalType">Metal Type:</label><input type="text" name="metalType"/><br/>';
        jewelleryQuestions += '<label for="jewelleryType">Jewellery Type: </label><input type="text" name="jewelleryType"/><br/>';
        specificQuestions.innerHTML = jewelleryQuestions;
      }

      //Adds unique questions for found pets.
      else if(categoryValue == "pet"){
        var petQuestions = '<label for="pet_name">Pet Name:</label><input type="text" name="pet_name"/><br/>';
        petQuestions += '<label for="animal">Animal: </label><input type="text" name="animal"/><br/>';
        petQuestions += '<label for="breed">Breed: </label><input type="text" name="breed"/><br/>';
        petQuestions += '<label for="collar_colour">Collar Colour: </label><input type="text" name="collar_colour"/><br/>';
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
          && ($_POST["category"] == "jewellery" || $_POST["category"] == "phone" || $_POST["category"] == "pet")
        ){
          try{
            #Uploads photo
            $photoName = date('Y-m-d') . "_" . date('h:i:s') . "_" . $_SESSION["user_id"] . "_" . $_FILES["photo"]["name"];
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

            if($_POST["category"] == "phone"){
              $phoneQuery = $db->prepare('INSERT INTO phone(item_id, brand, model) VALUES(?,?,?)');
              $phoneQuery->execute(array($recentlyAddedId, $_POST["brand"], $_POST["model"]));
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
    <form action="itemList.php" method="post">
      <input type="submit" value="Back to main laddy!"/>
    </form>
    <h1>Add an item</h1>
    <?php
      if($success == TRUE){
        echo "<p>Item added successfully!</p>";
      }
      else if ($success == FALSE && isset($_POST["submitted"])){
        echo "<p>Error adding item!</p>";
      }
    ?>

    <form id="addItemForm" action="addItem.php" method="POST" enctype="multipart/form-data">

      <label for="category">Category: </label>
      <select id="category" name="category" onchange="updateAddItemForm()" required>
          <option value="">Please Select...</option>
          <option value="phone">Phone</option>
          <option value="pet">Pet</option>
          <option value="jewellery">Jewellery</option>
      </select>
      <br/>

      <label for="found_date">Found Date <i>(dd/mm/yyyy)</i>: </label>
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
      <br/>

      <label for="found_place">Found Place <i>(City)</i>:</label>
      <input type="text" name="found_place" required/>
      <br/>

      <label for="colour">Main Colour of Object:</label>
      <input type="text" name="colour"/>
      <br/>

      <label for="description">Description: </label>
      <br/>
      <textarea name="description" rows="4" cols="25"></textarea>
      <br/>

      <label for="photo">Upload a photo:</label>
      <input type="file" name="photo" accept="image/*" />
      <br/>
      <span id="specificQuestions"></span>

      <input type="hidden" name="submitted" value="true"/>
      <input type="submit" name="submit" value="Add Item"/>
    </form>
  </body>
</html>
