<!DOCTYPE HTML>  
<html>
<head>
<style>
  .error {
  	color: red;
  }
</style>
<title>My Profile</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php 
include("session_variables.php");
?>

<?php
$creation_date = "";


// add entry to database here
$servername = "localhost";
$db_user = "root";
$db_password = "";
$dbname = "RedditCloneDB";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_user, $db_password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // begin the transaction
    $conn->beginTransaction();
    // our SQL statements
    // ensure username and email don't already exist in database
    $nameDBcheck = $conn->prepare("SELECT reg_date FROM users WHERE username=?");
    $nameDBcheck->execute([$_SESSION["username"]]);
    $result = $nameDBcheck->fetch();
    $creation_date = $result[0];
} catch(PDOException $e) {
    // roll back the transaction if something failed
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>

<h2>Profile Info</h2>
Account created: 
<?php 
	echo $creation_date;
	date_default_timezone_set('America/Los_Angeles');
	$datetime1 = strtotime($creation_date);
	$datetime2 = strtotime(date("Y-m-d h:i:sa"));

	$secs = $datetime2 - $datetime1;// == <seconds between the two times>
	$days = $secs / 86400;
	echo " (", floor($days), " day(s) ago)";
?>
</div>
</body>
</html>