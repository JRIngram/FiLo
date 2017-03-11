<!DOCTYPE>
<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  </head>
  <body>
    <form action="itemList.php" method="post">
      <input type="submit" value="Back to main laddy!"/>
    </form>
    <h1>Add an item</h1>
    <form action="addItem.php" method="POST">

      <label for="category">Category: </label>
      <select name="category" required>
          <option value="mobile">Phone</option>
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
      <textarea rows="4" cols="25">
      </textarea>
      <br/>

      <input type="submit" name="submit" value="Add Item"/>
    </form>
  </body>
</html>
