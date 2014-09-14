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
  <title>WINICOST - Edit Profile</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>WINICOST - Edit Profile</h3>

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

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
    $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
   
    $error = false;

    // Validate and move the uploaded picture file, if necessary
    

    // Update the profile data in the database
    if (!$error) {
      if (!empty($username) && !empty($password1) && !empty($password2) && ($password2 == $password1)) {
        // Only set the picture column if there is a new picture
        
          $query = "UPDATE cost SET username = '$username', password = SHA('$password1'), " . $_SESSION['user_id'] . "'";
           
        
        mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<p>Your profile has been successfully updated. Would you like to <a href="view_profile.php">view your profile</a>?</p>';

        mysqli_close($dbc);
        exit();
      }
      else {
        echo '<p class="error">You must enter all of the profile data .</p>';
      }
    }
  } // End of check for form submission
  else {
    // Grab the profile data from the database
    $query = "SELECT username, password FROM cost WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) {
      $username = $row['username'];
      $password1 = $row['password'];
      
    }
    else {
      echo '<p class="error">There was a problem accessing your profile.</p>';
    }
  }

  mysqli_close($dbc);
?>

  <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
    <fieldset>
      <legend>Personal Information</legend>
      <label for="username">username:</label>
      <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" /><br />
      <label for="password1">password:</label>
      <input type="password" id="password1" name="password1" value="<?php if (!empty($password1)) echo $password1; ?>" /><br />
      <label for="password2">retype password:</label>
      <input type="password" id="password2" name="password2" value="<?php if (!empty($password2)) echo $password2; else echo 'password2'; ?>" /><br />
      </fieldset>
    <input type="submit" value="Save Profile" name="submit" />
  </form>
</body> 
</html>
