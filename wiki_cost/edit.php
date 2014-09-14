<?php
  session_start();

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['username'] = $_COOKIE['username'];
    }
  }
  $id = $_GET['id'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>WiNiCost - Edit</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>WiniCost - Edit</h3>

<?php
  require_once('appvars.php');
  require_once('connectvars.php');

 
  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $country = mysqli_real_escape_string($dbc, trim($_POST['country']));
    $city = mysqli_real_escape_string($dbc, trim($_POST['city']));
    $product = mysqli_real_escape_string($dbc, trim($_POST['product']));
    $cost = mysqli_real_escape_string($dbc, trim($_POST['cost']));
    $currency = mysqli_real_escape_string($dbc, trim($_POST['currency']));
  
    $screenshot = $_FILES['screenshot']['name'];
    $screenshot_type = $_FILES['screenshot']['type'];
    $screenshot_size = $_FILES['screenshot']['size']; 
    $error = false;
   $target = GW_UPLOADPATH . $screenshot;
           move_uploaded_file($_FILES['screenshot']['tmp_name'], $target);

    // Update the profile data in the database
    if (!$error) {
      if (!empty($country) && !empty($city) && !empty($product) && !empty($currency) && !empty($cost) ) {
        // Only set the picture column if there is a new picture
        // $query = "UPDATE cost_date SET country = '$country', currency = '$currency',  cost = '$cost', product = '$product' WHERE id = $id ";
        
         $query = "INSERT INTO cost_date VALUES (0,'$country','$city','$product','$currency','$cost', '$screenshot')";


        mysqli_query($dbc, $query);
         $query = "SELECT id FROM cost_date WHERE country=$country, city = $city, product = $product, currency = $currency, cost = $currency, screenshot = $screenshot ";
          mysqli_query($dbc, $query);
        $id = $row['id']-1;

         $query = "DELETE FROM cost_date WHERE id = $id LIMIT 1";
          mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<p>Your cost has been successfully updated. Would you like to <a href="view_info.php">view your cost</a>?</p>';
        
        
        mysqli_close($dbc);
        exit();
      }
      else {
        echo '<p class="error">You must enter all of the profile data (the picture is optional).</p>';
      }
    }
  } // End of check for form submission
  else {
    // Grab the profile data from the database
    $query = "SELECT country, city, cost, currency, product, screenshot FROM cost_date WHERE id = $id";

    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
    $query = "DELETE FROM cost_date WHERE id = $id LIMIT 1";

    $data = mysqli_query($dbc, $query);
    if ($row != NULL) {
      $country = $row['country'];
      $city = $row['city'];
      $product = $row['product'];
      $cost = $row['cost'];
      $currency = $row['currency'];
      $screenshot = $row['screenshot'];
      }
    else {
      echo '<p class="error">There was a problem accessing your profile.</p>';
    }
    $query = "INSERT INTO cost_date VALUES (0,'$country','$city','$product','$currency','$cost', '$screenshot')";
  }

  mysqli_close($dbc);
?>

  <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
    <fieldset>
      <legend>cost</legend>
      <label for="country">country:</label>
      <input type="text" id="country" name="country" value="<?php if (!empty($country)) echo $country; ?>" /><br />
      <label for="city">city:</label>
      <input type="text" id="city" name="city" value="<?php if (!empty($city)) echo $city; ?>" /><br />
      <label for="product">product:</label>
      <input type="text" id="product" name="product" value="<?php if (!empty($product)) echo $product;  ?>" /><br />
      <label for="currency">currency:</label>
      <input type="text" id="currency" name="currency" value="<?php if (!empty($currency)) echo $currency; ?>" /><br />
      <label for="cost">cost:</label>
      <input type="text" id="cost" name="cost" value="<?php if (!empty($cost)) echo $cost; ?>" /><br />
      <label for="screenshot">Screen shot:</label>
      <input type="file" id="screenshot" name="screenshot" />
    
    </fieldset>
    <input type="submit" value="Save Profile" name="submit" />
  </form>
</body> 
</html>