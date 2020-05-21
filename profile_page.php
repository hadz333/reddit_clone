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
    // grab user's registration date
    $regdate = $conn->prepare("SELECT reg_date FROM users WHERE username=?");
    $regdate->execute([$_SESSION["username"]]);
    $result = $regdate->fetch();
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

<h2>Post History</h2>
<div id="post_list">
<?php
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

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_user, $db_password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // begin the transaction
    $conn->beginTransaction();

    // grab user's post history
    $grab_post_history = $conn->prepare("SELECT id, username, title, reg_date FROM posts WHERE username=?");
    $grab_post_history->execute([$_SESSION["username"]]);
    $result = $grab_post_history->fetchAll();
    for ($i = 0; $i < sizeof($result); $i++) {
        $postid = $result[$i]["id"];
        echo "<a href='?postid=$postid'>";
        echo "<div id='post_thumbnail'>";
        echo $result[$i]["title"];
        echo "<div id='post_description'>";
        echo "By: ", $result[$i]["username"], "&emsp;";
        echo "Posted ", $result[$i]["reg_date"];
        echo "</div>";
        echo "</div>";
        echo "</a>";
    }
} catch(PDOException $e) {
    // roll back the transaction if something failed
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
</div>
</div>
</body>
</html>