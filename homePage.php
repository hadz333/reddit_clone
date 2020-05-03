<!DOCTYPE html>
<html>
<head>
	<title>Reddit 2</title>
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
This is the site's home page.

<?php include("session_variables.php"); ?>
</body>
</html>