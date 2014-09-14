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
  <title>WIKICOST - Edit Profile</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>WIKICOST - Edit Profile</h3>

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
        echo '<p>Your profile has been successfully updated. Would you like to <a href="viewprofile.php">view your profile</a>?</p>';

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
    $query = "SELECT first_name, last_name, gender, birthdate, city, state, picture FROM mismatch_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) {
      $first_name = $row['first_name'];
      $last_name = $row['last_name'];
      $gender = $row['gender'];
      $birthdate = $row['birthdate'];
      $city = $row['city'];
      $state = $row['state'];
      $old_picture = $row['picture'];
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
      <label for="firstname">First name:</label>
      <input type="text" id="firstname" name="firstname" value="<?php if (!empty($first_name)) echo $first_name; ?>" /><br />
      <label for="lastname">Last name:</label>
      <input type="text" id="lastname" name="lastname" value="<?php if (!empty($last_name)) echo $last_name; ?>" /><br />
      <label for="gender">Gender:</label>
      <select id="gender" name="gender">
        <option value="M" <?php if (!empty($gender) && $gender == 'M') echo 'selected = "selected"'; ?>>Male</option>
        <option value="F" <?php if (!empty($gender) && $gender == 'F') echo 'selected = "selected"'; ?>>Female</option>
      </select><br />
      <label for="birthdate">Birthdate:</label>
      <input type="text" id="birthdate" name="birthdate" value="<?php if (!empty($birthdate)) echo $birthdate; else echo 'YYYY-MM-DD'; ?>" /><br />
      <label for="city">City:</label>
      <input type="text" id="city" name="city" value="<?php if (!empty($city)) echo $city; ?>" /><br />
      <label for="state">State:</label>
      <input type="text" id="state" name="state" value="<?php if (!empty($state)) echo $state; ?>" /><br />
      <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>" />
      <label for="new_picture">Picture:</label>
      <input type="file" id="new_picture" name="new_picture" />
      <?php if (!empty($old_picture)) {
        echo '<img class="profile" src="' . MM_UPLOADPATH . $old_picture . '" alt="Profile Picture" />';
      } ?>
    </fieldset>
    <input type="submit" value="Save Profile" name="submit" />
  </form>
</body> 
</html>
