<?php
  session_start();

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['username'] = $_COOKIE['username'];
    }
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>WINICOST - View Profile</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>WINICOST - View Profile</h3>

<?php

  require_once('appvars.php');
  require_once('connectvars.php');
  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
  }
  else {
    echo('<p class="login">You are logged in as ' . $_SESSION['username'] . '. <a href="logout.php">Log out</a>.</p>');
  }

  // Connect to the database
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

  // Grab the profile data from the database
  if (!isset($_GET['user_id'])) {
    $query = "SELECT username FROM cost WHERE user_id = '" . $_SESSION['user_id'] . "'";
  }
  else {
    $query = "SELECT username FROM cost WHERE us1er_id = '" . $_GET['user_id'] . "'";
  }
  $data = mysqli_query($dbc, $query);

  if (mysqli_num_rows($data) == 1) {
    // The user row was found so display the user data
    $row = mysqli_fetch_array($data);
    echo '<table>';
   
    if (!empty($row['last_name'])) {
     echo '&#10084; <a href="country.php">country</a><br />' ;
    }
   
 
    echo '</table>';
    if (!isset($_GET['user_id']) || ($_SESSION['user_id'] == $_GET['user_id'])) {
      echo '<p>Would you like to <a href="edit_profile.php">edit your profile</a>?</p>';
       echo '<p><a href="index.php">&lt;&lt; Back to mainpage</a></p>';
    }
  } // End of check for a single row of user results
  else {
    echo '<p class="error">There was a problem accessing your profile.</p>';
  }

  mysqli_close($dbc);
?>
</body> 
</html>
