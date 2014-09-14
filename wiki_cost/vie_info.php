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
  <title>WIKICOST - View the cost of world</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>WIKI COST - View the cost of world</h3>

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
  while ($row = mysqli_fetch_array($data)) { 
    // Display the score data


            $country = "";
            $city = "";
            $product = "";
            $currency ="";
            $cost ="";

    echo '<tr><td class="scoreinfo">';
    echo '<strong>coutnry:</strong> ' . $row['country'] . '<br />';
    echo '<strong>city:</strong> ' . $row['city'] . '<br />';
    echo '<strong>product:</strong> ' . $row['product'] . '<br />';
    echo '<strong>currency:</strong> ' . $row['currency'] . '<br />';
    echo '<strong>cost:</strong> ' . $row['cost'] . '</td>';
    
  }
  echo '</table>';

  mysqli_close($dbc);
?>

</body> 
</html>
