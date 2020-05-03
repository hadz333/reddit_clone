<!DOCTYPE html>
<html>
<head>
	<title>Log in to Reddit 2</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php 
include("session_variables.php"); 

if ($_SESSION["loggedIn"]) {
	include("navbar_signed_in.html");
} else {
	include("navbar_not_signed_in.html");
}
?>
<center>
<h3> Reddit 2 </h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
  Username: <input type="text" name="username">
  <br>
  Password: <input type="text" name="password">
  <br>
  <input type="submit" value="Sign in">
</form>

<?php
// retrieve user from database, check if password is correct.
// if user not found, provide error message that the user does not exist.
$usernameErr = $emailErr = $passwordErr = "";
?>
</center>
</body>
</html>