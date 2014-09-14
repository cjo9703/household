<?php

  require_once('appvars.php');
  require_once('connectvars.php');
  // Start the session
  session_start();

  // Clear the error message
  $error_msg = "";

  // If the user isn't logged in, try to log them in
  if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['submit'])) {
      // Connect to the database
       $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);



      // Grab the user-entered log-in data
      $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($user_username) && !empty($user_password)) {
        // Look up the username and password in the database
        $query = "SELECT user_id, username, password FROM cost WHERE username = '$user_username' AND password = '$user_password' ";
        $data = mysqli_query($dbc, $query);

        if(mysqli_num_rows($data) == 1){
          // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page
          $row = mysqli_fetch_array($data);
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['username'] = $row['username'];
          $_SESSION['password'] = $row['password'];
          setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
          setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
          setcookie('password', $row['password'], time() + (60 * 60 * 24 * 30));
          $home_url = /*'http://localhost/beta/index_k.php';*/'http://worldcost.comoj.com/wiki_cost/index_k.php';
          header('Location: ' . $home_url);
        }
        else {
          // The username/password are incorrect so set an error message
          $error_msg = 'ID 혹은 암호 정보가 맞지 않다고 거부하는데요..';
        }
      }
      else {
        // The username/password weren't entered so set an error message
        $error_msg = '아이디가 암호중 적지 않은게 잇대요.';
      }
    }
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>위니코스트 - 로그인하기</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>위니코스트 - 로그인 하기 </h3>

<?php
  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['user_id'])) {
    echo '<p class="error">' . $error_msg . '</p>';
?>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Log In</legend>
      <label for="username">ID:</label>
      <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" /><br />
     
      <label for="password">암호:</label>
      <input type="password" id="password" name="password" />
    </fieldset>
    <input type="submit" value="Log In" name="submit" />
  </form>

<?php
  }
  else {
    // Confirm the successful log-in
    echo('<p class="login">현재 당신은 ' . $_SESSION['username'] . '로 로그인 했습니다 .</p>');
  }
?>

</body>
</html>
