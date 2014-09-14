<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>WINI_COST - Remove COST</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h2>WINI_COST - Remove COST</h2>

<?php
  require_once('appvars.php');
  require_once('connectvars.php');


    $id = $_GET['id'];
    $coutnry = $_GET['country'];
    $city = $_GET['city'];
    $product = $_GET['product'];
    $currency = $_GET['currency'];
    $cost = $_GET['cost'];
    $screenshot = $_GET['screenshot'];

    echo '<p>Are you sure you want to delete the following high score?</p>';
    echo '<p><strong>country: </strong>' . $country . '<br /><strong>city: </strong>' . $city .
      '<br /><strong>product: </strong>' . $product . '</p>';
    echo '<p><strong>currency: </strong>' . $currency . '<br /><strong>cost: </strong>' . $cost .
       '</p>';
    echo '<form method="post" action="removescore.php">';
    echo '<input type="radio" name="confirm" value="Yes" /> Yes ';
    echo '<input type="radio" name="confirm" value="No" checked="checked" /> No <br />';
    echo '<input type="submit" value="Submit" name="submit" />';
    echo '<input type="hidden" name="id" value="' . $id . '" />';
    echo '<input type="hidden" name="product" value="' . $product . '" />';
    echo '<input type="hidden" name="cost" value="' . $cost . '" />';

    echo '</form>';

  if (isset($_GET['id']) && isset($_GET['country']) && isset($_GET['city']) && isset($_GET['country'])) {
    // Grab the score data from the GET
    $id = $_GET['id'];
    $coutnry = $_GET['country'];
    $city = $_GET['city'];
    $product = $_GET['product'];
    $currency = $_GET['currency'];
    $cost = $_GET['cost'];
     $screenshot = $_GET['screenshot'];
    
  }
  else if (isset($_POST['id']) && isset($_POST['product']) && isset($_POST['cost'])) {
    // Grab the score data from the POST
    $id = $_POST['id'];
    $name = $_POST['product'];
    $score = $_POST['cost'];
  }
  else {
    echo '<p class="error">Sorry, no information was specified for removal.</p>';
  }

  if (isset($_POST['submit'])) {
    if ($_POST['confirm'] == 'Yes') {
       //Delete the screen shot image file from the server
      @unlink(GW_UPLOADPATH . $screenshot);

      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

      // Delete the score data from the database
      $query = "DELETE FROM cost_date WHERE id = $id LIMIT 1";
      mysqli_query($dbc, $query);
      mysqli_close($dbc);

      // Confirm success with the user
      echo '<p>The high score of ' . $cost . ' for ' . $product . ' was successfully removed.';
    }
    else {
      echo '<p class="error">The high score was not removed.</p>';
    }
  }
  else if (isset($id) && isset($counry) && isset($cost) && isset($currenct)) {
    echo '<p>Are you sure you want to delete the following high score?</p>';
    echo '<p><strong>country: </strong>' . $country . '<br /><strong>city: </strong>' . $city .
      '<br /><strong>product: </strong>' . $product . '</p>';
    echo '<p><strong>currency: </strong>' . $currency . '<br /><strong>cost: </strong>' . $cost .
       '</p>';
    echo '<form method="post" action="removescore.php">';
    echo '<input type="radio" name="confirm" value="Yes" /> Yes ';
    echo '<input type="radio" name="confirm" value="No" checked="checked" /> No <br />';
    echo '<input type="submit" value="Submit" name="submit" />';
    echo '<input type="hidden" name="id" value="' . $id . '" />';
    echo '<input type="hidden" name="product" value="' . $product . '" />';
    echo '<input type="hidden" name="cost" value="' . $cost . '" />';
    echo '</form>';
  }

  echo '<p><a href="admin.php">&lt;&lt; Back to remove page</a></p>';
?>

</body> 
</html>
