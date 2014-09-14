<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>WINI COST - Add the cost</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h2>WINI COST - Add the cost</h2>

<?php
  require_once('appvars.php');
  require_once('connectvars.php');

  if (isset($_POST['submit'])) {
    // Grab the score data from the POST
    $country  = $_POST['country'];
    $city     = $_POST['city'];
    $product  = $_POST['product'];
    $currency = $_POST['currency'];
    $cost     = $_POST['cost'];
     


    $screenshot = $_FILES['screenshot']['name'];
    $screenshot_type = $_FILES['screenshot']['type'];
    $screenshot_size = $_FILES['screenshot']['size']; 


    //$screenshot = $_FILES['screenshot']['name'];
    //$screenshot_type = $_FILES['screenshot']['type'];
    //$screenshot_size = $_FILES['screenshot']['size']; 

    if (!empty($country) && !empty($city)) {

       if (!empty($country)) {
        if ($_FILES['screenshot']['error'] == 0) {
          // Move the file to the target upload folder
          $target = GW_UPLOADPATH . $screenshot;
          if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
            // Connect to the database
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            // Write the data to the database
            $query = "INSERT INTO cost_date VALUES (0,'$country','$city','$product','$currency','$cost', '$screenshot')";
            mysqli_query($dbc, $query);

            // Confirm success with the user
            echo '<p>Thanks for adding your new cost! </p>';
        
            echo '<strong>country:</strong> ' . $country . '<br />';
            echo '<strong>city:</strong> ' . $city . '<br />';
            echo '<strong>product:</strong> ' . $product . '<br />';
            echo '<strong>city:</strong> ' . $currency . '<br />';
            echo '<strong>city:</strong> ' . $cost . '<br />';
            echo '<img src="' . GW_UPLOADPATH . $screenshot . '" alt="Score image" /></p>';
            echo '<p><a href="index.php">&lt;&lt; Back to mainpage</a></p>';

            // Clear the score data to clear the form
            $country = "";
            $city = "";
            $product = "";
            $currency ="";
            $cost ="";
            $screenshot = "";
            mysqli_close($dbc);
         }
          else {
            echo '<p class="error">Sorry, there was a problem uploading your screen shot image.</p>';
          }
        }
      }
      else {
       echo '<p class="error">The screen shot must be a GIF, JPEG, or PNG image file no greater than ' . (GW_MAXFILESIZE / 1024) . ' KB in size.</p>';
      }

     // Try to delete the temporary screen shot image file
      @unlink($_FILES['screenshot']['tmp_name']);
    }
    else {
      echo '<p class="error">Please enter all of the information to add the socre.</p>';
    }
  }
?>

  <hr />
  <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo GW_MAXFILESIZE; ?>" />
    <label for="country">country:</label>
    <input type="text" id="country" name="country" value="<?php if (!empty($country)) echo $country; ?>" /><br />
    <label for="city">city:</label>
    <input type="text" id="city" name="city" value="<?php if (!empty($city)) echo $city; ?>" /><br />
    <label for="product">product:</label>
    <input type="text" id="product" name="product" value="<?php if (!empty($product)) echo $product; ?>" /><br />
    <label for="currency">currency:</label>
    <input type="text" id="currency" name="currency" value="<?php if (!empty($currency)) echo $currency; ?>" /><br />
    <label for="cost">cost:</label>
    <input type="text" id="cost" name="cost" value="<?php if (!empty($cost)) echo $cost; ?>" /><br />
    <label for="screenshot">Screen shot:</label>
    <input type="file" id="screenshot" name="screenshot" />
    <hr />
    <input type="submit" value="Add" name="submit" />
  </form>
</body> 
</html>
