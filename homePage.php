<!DOCTYPE html>
<html lang="en">
<head>
  <title>Reddit 2</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <?php 
include("session_variables.php"); 

if ($_SESSION["loggedIn"]) {
	include("navbar_signed_in.html");
} else {
	include("navbar_not_signed_in.html");
}
?>
This is the site's home page.
<?php include("session_variables.php"); ?>
</div>

</body>
</html>