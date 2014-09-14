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
  <title>WiNi Cost - Product Image</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h2>WiNi Cost - Product Image</h2>
  <p>If you want to go back <a href="view_info.php">Click</a>.</p>
  <hr />

<?php
  require_once('appvars.php');
  require_once('connectvars.php');

  // Connect to the database 
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
    $id = $_GET['id'];
  // Retrieve the score data from MySQL

    $query = "SELECT country, city, cost, currency, product, screenshot FROM cost_date WHERE id = $id";

    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);
    

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


  // Loop through the array of score data, formatting it as HTML 
    echo '<table>';
    echo '<tr><td class="scoreinfo">';
    
    echo '<strong>Country:</strong> ' . $row['country'] . '<br />';
    echo '<strong>City:</strong> ' . $row['city'] . '<br />';
    echo '<strong>Product:</strong> ' . $row['product'] . '<br />';
     echo '<strong>Cost:</strong> ' . $row['cost'] . '<br />';
    if (is_file(GW_UPLOADPATH . $row['screenshot']) ) {
      echo '<td><img src="' . GW_UPLOADPATH . $row['screenshot'] . '" alt="Score image" /></td></tr>';
    }
    else {
      echo '<td><img src="' . GW_UPLOADPATH . 'unverified.gif' . '" alt="Unverified score" /></td></tr>';
    }

  echo '</table>';

  mysqli_close($dbc);
?>

</body> 
</html>
