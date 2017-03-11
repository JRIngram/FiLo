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
      if(categoryValue == "jewellery"){
        var jewelleryQuestions = '<label for="metalType">Metal Type:</label><input type="text" name="metalType"/><br/>';
        jewelleryQuestions += '<label for="jewelleryType">Jewellery Type: </label><input type="text" name="jewelleryType"/><br/>';
        specificQuestions.innerHTML = jewelleryQuestions;
      }

      //Adds unique questions for found pets.
      if(categoryValue == "pet"){
        var petQuestions = '<label for="pet_name">Pet Name:</label><input type="text" name="pet_name"/><br/>';
        petQuestions += '<label for="animal">Animal: </label><input type="text" name="animal"/><br/>';
        petQuestions += '<label for="breed">Breed: </label><input type="text" name="breed"/><br/>';
        petQuestions += '<label for="collar_colour">Collar Colour: </label><input type="text" name="collar_colour"/><br/>';
        specificQuestions.innerHTML = petQuestions;
      }
    }
    </script>
  </head>
  <body>
    <form action="itemList.php" method="post">
      <input type="submit" value="Back to main laddy!"/>
    </form>
    <h1>Add an item</h1>
    <form id="addItemForm" action="addItem.php" method="POST">

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
      <input type="text" name="colour" required/>
      <br/>

      <label for="description">Description: </label>
      <br/>
      <textarea rows="4" cols="25"></textarea>
      <br/>

      <span id="specificQuestions"></span>

      <input type="submit" name="submit" value="Add Item"/>
    </form>
  </body>
</html>
