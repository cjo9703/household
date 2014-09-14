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
  <title>가격과 삶</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3 style="text-align:center;">위니 코스트 - 지구촌의 가격 <br /> <br/>
  <p> <img src="images/earth.jpg"  width ="10" height="10"></p><br/>
  </h3> 
<?php
  
  require_once('appvars.php');
  require_once('connectvars.php');
  // Generate the navigation menu
  if (isset($_SESSION['username'])) {
    echo '&#10084; <a href="view_profile_k.php" >프로필 보기</a><br />';
    echo '&#10084; <a href="edit_profile_k.php" >프로필 편집</a><br />';
    echo '&#10084; <a href="view_info_k.php"  >가격정보보기</a><br />';
    echo '&#10084; <a href="add_info_k.php">가격정보 올리기</a><br />';
    echo '&#10084; <a href="admin_k.php">가격정보 지우기 </a><br />';
    echo '&#10084; <a href="logout_k.php">위니코스트 퇴장(' . $_SESSION['username'] . ')</a><br/><br/><br/><br/>';
    echo '&#10084; <a href="problem_k.html">문제점</a><br />';
    echo '&#10084; <a href="reason_k.html">사이트 제작 동기</a><br />';
    echo '&#10084; <a href="index.php">see by english</a><br />';
  }
  else {
    echo '&#10084; <a href="login_k.php">위니코스트 입장 </a><br />';
    echo '&#10084; <a href="view_info_k.php"  >가격정보 보기 </a><br />';
    echo '&#10084; <a href="index.php">see by english</a><br />';
    echo '&#10084; <a href="signup_k.php">등록 </a>';
  }

  // Connect to the database 
   $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


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

  mysqli_close($dbc);
?>


<p>궁금한 점이 있으면  언제든지 보내주세요. 우편번호 : cjo9703@naver.com </p>
</body> 
</html>
