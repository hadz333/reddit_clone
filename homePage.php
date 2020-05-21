<!DOCTYPE html>
<html lang="en">
<head>
  <title>Reddit 2</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div class="container">
  <?php 
	include("session_variables.php"); 
  ?>

<?php

if (isset($_SESSION["username"])) {
	echo "<a href='create_post.php'>+ Create post</a>";
} else {
	echo "<a href='login_page.php'>+ Create post</a>";
}

?>

</div>

</body>
</html>