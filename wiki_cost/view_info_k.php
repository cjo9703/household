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
  <title>위니코스트 - 가격정보 보기</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>위니코스트 - 가격정보 보기</h3>

<?php
  require_once('appvars.php');
  require_once('connectvars.php');

  // Connect to the database 
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

  // Retrieve the score data from MySQL
  $query = "SELECT * FROM cost_date ";
  $data = mysqli_query($dbc, $query);

  // Loop through the array of score data, formatting it as HTML 
  echo '<table>';
  $i = 0;
    echo '<tr class="scoreinfo">';
    echo '<td valign="top" width="20%">' . '<strong>나라</strong>' . '</td>';
    echo  '<td valign="top" width="20%">' . '<strong>도시</strong>' . '</td>';
    echo  '<td valign="top" width="30%">' . '<strong>물건</strong>' . '</td>';
    echo '<td valign="top" width="10%">' . '<strong>돈단위</strong>' . '</td>';
    echo '<td valign="top" width="20%">' . '<strong>비용</strong>' . '</td>';
    echo '</tr>';
  while ($row = mysqli_fetch_array($data)) { 
    // Display the score data


            $country = "";
            $city = "";
            $product = "";
            $currency ="";
            $cost ="";

   /* echo '<tr class="results">';
    echo '<td valign="top" width="20%">' . $row['title'] . '</td>';
    echo '<td valign="top" width="50%">' . substr($row['description'], 0, 100) . '...</td>';
    echo '<td valign="top" width="10%">' . $row['state'] . '</td>';
    echo '<td valign="top" width="20%">' . substr($row['date_posted'], 0, 10) . '</td>';
    echo '</tr>';/*/

    echo '<tr class="scoreinfo">';
    echo '<td valign="top" width="20%">' . $row['country'] . '</td>';
    echo  '<td valign="top" width="20%">' . substr($row['city'],0,100) . '...</td>';
    echo  '<td valign="top" width="30%">' . $row['product'] . '</td>';
    echo '<td valign="top" width="10%">' . $row['currency'] . '</td>';
    echo '<td valign="top" width="20%">' . $row['cost'] . '</td>';
    echo '</tr>';
  }
  echo '<p><a href="index_k.php">&lt;&lt; Back to mainpage</a></p>';
//  echo '<p><a href="search.html"> If you want to search, click.</a></p>';

  echo '</table>';

  mysqli_close($dbc);
?>

</body> 
</html>