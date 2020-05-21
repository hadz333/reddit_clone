<!DOCTYPE HTML>  
<html>
<head>
<style>
  .error {
  	color: red;
  }
</style>
<title>Sign up for Reddit 2</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php 
include("session_variables.php");
unset($_SESSION['username']);
header("Location: http://127.0.0.1/phpProjects/reddit_clone/homePage.php");
?>

<h2>You have successfully signed out.</h2>
<button action="homePage.php">Home</button>

</div>
</body>
</html>