<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>위니 코스트 - 가격 삭제</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h2>위니 코스트 - 가격 삭제</h2>
  <p>실제 맞지 않는 가격을 삭제하세요</p>
  <hr />

<?php
  require_once('appvars.php');
  require_once('connectvars.php');

  // Connect to twikhe database 
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

  // Retrieve the score data from MySQL
  $query = "SELECT * FROM cost_date ";
  $data = mysqli_query($dbc, $query);

  // Loop through the array of score data, formatting it as HTML 
  echo '<table>';
  while ($row = mysqli_fetch_array($data)) { 
    // Display the score data
    echo '<tr class="scorerow"><td><strong>' . $row['country'] . '</strong></td>';
    echo '<td>' . $row['city'] . '</td>';
    echo '<td>' . $row['product'] . '</td>';
    echo '<td>' . $row['currency'] . '</td>';
    echo '<td>' . $row['cost'] . '</td>';
    echo '<td><a href="removescore.php?id=' . $row['id'] . '&amp;country=' . $row['country'] .
      '&amp;city=' . $row['city'] . '&amp;product=' . $row['product'] .
      '&amp;currency=' . $row['currency'] . '&amp;cost=' . $row['cost'] .'">삭제</a></td></tr>';
  }

  echo '</table>';
  echo '<p><a href="index_k.php">&lt;&lt; 메인페이지로 돌아가기</a></p>';
  mysqli_close($dbc);
?>

</body> 
</html>
