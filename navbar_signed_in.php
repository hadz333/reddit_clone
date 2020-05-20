<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div id="home_link">
<a href="homePage.php">Home</a>
</div>
<div id="signed_in_navbar">
<a href="profile_page.php"><?php echo $_SESSION["username"]; ?></a>
| 
<a href="signed_out.php">Sign out</a>
</div>
</body>
</html>