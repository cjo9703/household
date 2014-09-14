<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>위니코스트 - 가입</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>위니코스트 - 가입</h3>

<?php
  require_once('appvars.php');
  require_once('connectvars.php');
  
  // Connect to the database
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
    $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
    

    if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
      // Make sure someone isn't already registered using this username
      $query = "SELECT * FROM cost where username = '$username'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        // The username is unique, so insert the data into the database
        $query = "INSERT INTO cost (username, password) VALUES ('$username', SHA('$password1'))";
        mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<p> 위니코스트의 회원이 되셨습니다. <a href="login_k.php">로그인</a>해 주세요 .</p>';

        mysqli_close($dbc);
        exit();
      }
      else {
        // An account already exists for this username, so display an error message
        echo '<p class="error">다른 회원께서 쓰시고 계십니다.</p>';
        $username = "";
      }
    }
    else {
      echo '<p class="error">위니코스트에 가입하기 위한 정보가 부족합니다.</p>';
    }
  }

  mysqli_close($dbc);
?>

  <p>Please enter your username and desired password to sign up to Mismatch.</p>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>위니코스트 접속 정보</legend>
      <label for="username">ID :</label>
      <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" /><br />
      <label for="password1">암호:</label>
      <input type="password" id="password1" name="password1" /><br />
      <label for="password2">암호(다시 적어보기):</label>
      <input type="password" id="password2" name="password2" /><br />
      
    </fieldset>
    <input type="submit" value="Sign Up" name="submit" />
  </form>
</body> 
</html>
