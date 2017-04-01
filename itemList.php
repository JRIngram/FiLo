<!DOCTYPE html>

<?php
  session_start();
  $db = new PDO("mysql:dbname=fifo;host=localhost", "root", "");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if(!isset($_GET["category"]) || $_GET["category"] == "all"){
    $itemQuery = $db->query('SELECT * FROM item');
  }

  else if($_GET["category"] == "electronic"){
    $itemQuery = $db->query('SELECT * FROM item WHERE category = "electronic"');
  }

  else if($_GET["category"] == "jewellery"){
    $itemQuery = $db->query('SELECT * FROM item WHERE category = "jewellery"');
  }

  else if($_GET["category"] == "pet"){
    $itemQuery = $db->query('SELECT * FROM item WHERE category = "pet"');
  }

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
    <?php include('navbar.php'); ?>
    <div style="width: 500px; margin: auto" class="page-header">
      <h1>Item List
        <?php
          if(!isset($_SESSION["username"])){
      ?>
            <small> - Please <a href="index.html">login</a> to see more details</small>
      <?php } ?>
      </h1>

          <?php
          if(isset($_SESSION["username"])){
            ?>
            <div class="row">
              <div>
                <form name="searchItemCategory" method="GET" action="itemList.php">
                  <label for="category">Select category to browse by:</label>
                  <select style="display: inline;margin: auto; width: 70%; " class="form-control" id="category" name="category" onchange="updateAddItemForm()" required>
                    <?php
                    if(!isset($_GET["category"]) || $_GET["category"] == "all"){
                    ?>
                      <option selected="true" value="all">View all Items</option>
                      <option value="electronic">Electronic</option>
                      <option value="jewellery">Jewellery</option>
                      <option value="pet">Pet</option>
                    <?php
                    }

                    else if($_GET["category"] == "electronic"){
                      ?>
                        <option value="all">View all Items</option>
                        <option selected="true"  value="electronic">Electronic</option>
                        <option value="jewellery">Jewellery</option>
                        <option value="pet">Pet</option>
                      <?php
                    }

                    else if($_GET["category"] == "jewellery"){
                      ?>
                        <option value="all">View all Items</option>
                        <option value="electronic">Electronic</option>
                        <option selected="true" value="jewellery">Jewellery</option>
                        <option value="pet">Pet</option>
                      <?php
                    }

                    else if($_GET["category"] == "pet"){
                      ?>
                        <option value="all">View all Items</option>
                        <option value="electronic">Electronic</option>
                        <option value="jewellery">Jewellery</option>
                        <option selected="true" value="pet">Pet</option>
                      <?php
                    }
                    ?>
                  </select>
                  <input style="display: inline;width: 25%;" class="btn btn-info" type="submit" value="Search!" name="categorySearch"/>
                  <br/>
                </form>
              </div>
           </div>
          <?php
          }
          ?>
        <ul class="list-group">
        <?php
          foreach($items as $item){
            $itemObj = json_decode($item);
            $itemId = $itemObj->{"item_id"};
        ?>
            <li class="list-group-item">
              <p><b>Basic details for Item <?php echo $itemId ?>: </b></p>
              <p><?php echo $itemObj->{"found_date"} . ", " . $itemObj->{"found_place"} . ", " . $itemObj->{"category"}?>.</p>
              <?php
                if(isset($_SESSION["username"])){
              ?>
                  <form method="GET" action="detailItem.php">
                    <input type="hidden" name="itemId" value="<?php echo $itemObj->{'item_id'} ?>" />
                    <input class="btn btn-info" type="submit" value="More Detail" name="submit"/>
                  </form>
              <?php
                }
              ?>
            </li>
        <?php
          }
        ?>
      </ul>
    </div>
  </body>
</html>
