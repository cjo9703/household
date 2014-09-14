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
  <title>Cost in your lives</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body style="text-align:center;">
  <h3 style="text-align:center;">Wini Cost-Cost in your lives<br/>
  <p> <img src="images/earth.jpg"  width ="272" height="249"></p><br/>
  </h3> 
<?php
  require_once('appvars.php');
  require_once('connectvars.php');
    // Generate the navigation menu
  if (isset($_SESSION['username'])) {
    echo '<a style="text-align:center;" href="view_profile.php" >View profile</a><br />' ;
    echo ' <a href="edit_profile.php" >Edit   profile</a><br /><br/>';
    echo ' <a href="view_info.php"  >View cost</a><br />';
    echo ' <a href="add_info.php">add cost</a><br />';
    echo ' <a href="admin.php">remove cost</a><br /><br/>';
    echo ' <a href="logout.php">Log Out (' . $_SESSION['username'] . ')</a><br/><br/><br/>';
      //  echo ' <a href="problem.html">problem</a><br />';
        echo ' <a href="reason.html">reason of makinga</a><br />';
        echo ' <a href="index_k.php">한국어로 보기</a><br />';
  }
  else {
    echo '  <a href="login.php">Log In</a><br />';
    echo ' <a href="view_info.php"  >View cost</a><br />';
    echo ' <a href="signup.php">Sign Up</a><br/><br/><br/>';
    echo ' <a href="problem.html">problem</a><br />';
    echo ' <a href="index_k.php">한국어로 보기</a><br />';
  }

  // Connect to the database 
  /* $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


  // Retrieve the user data from MySQL
  $query = "SELECT user_id, username FROM cost WHERE username  IS NOT NULL ORDER BY user_id DESC LIMIT 5";
  $data = mysqli_query($dbc, $query);

  // Loop through the array of user data, formatting it as HTML
  echo '<h4>Latest members:</h4>';
  echo '<table>';
  while ($row = mysqli_fetch_array($data)) {
    if (is_file(MM_UPLOADPATH . $row['picture']) && filesize(MM_UPLOADPATH . $row['picture']) > 0) {
      echo '<tr><td><img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="' . $row['username '] . '" /></td>';
    }
    else {
      echo '<tr><td><img src="' . MM_UPLOADPATH . 'nopic.jpg' . '" alt="' . $row['username '] . '" /></td>';
    }
    if (isset($_SESSION['user_id'])) {
      echo '<td><a href="viewprofile.php?user_id=' . $row['user_id'] . '">' . $row['username '] . '</a></td></tr>';
    }
    else {
      echo '<td>' . $row['username '] . '</td></tr>';
    }
  }
  echo '</table>';

  mysqli_close($dbc);*/
?>

<p>If you have any question or suggestion, send the email to : cjo9703@naver.com </p>
</body> 
</html>
