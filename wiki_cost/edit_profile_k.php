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
  <title>위니 코스트 - 프로필 편집</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>위니 코스트 - 프로필 편집 </h3>

<?php
  require_once('appvars.php');
  require_once('connectvars.php');

  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login"> <a href="login.php">접속</a> 이 필요합니다.</p>';
    exit();
  }
  else {
    echo('<p class="login">ID가  ' . $_SESSION['username'] . '이시군요. <a href="logout_k.php">퇴장 </a>하시겠습니까?</p>');
     echo '<p><a href="index_k.php">&lt;&lt; Back to mainpage</a></p>';
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
        echo '<p>프로필이 성공적으로 바뀌었습니다  <a href="view_profile_k.php">프로필정보를</a>보시겠습니까?</p>';

        mysqli_close($dbc);
        exit();
      }
      else {
        echo '<p class="error">프로필정보를 다 적지 않으셨습니다 .</p>';
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
      echo '<p class="error">프로필에 접속하기 위한 정보를 다 적지 않으셨습니다.</p>';
    }
  }

  mysqli_close($dbc);
?>

  <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
    <fieldset>
      <legend> 프로필 </legend>
      <label for="username">ID:</label>
      <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" /><br />
      <label for="password1">암호:</label>
      <input type="password" id="password1" name="password1" value="<?php if (!empty($password1)) echo $password1; ?>" /><br />
      <label for="password2">암호재입력:</label>
      <input type="password" id="password2" name="password2" value="<?php if (!empty($password2)) echo $password2; else echo 'password2'; ?>" /><br />
      </fieldset>
    <input type="submit" value="Save Profile" name="submit" />
  </form>
</body> 
</html>
