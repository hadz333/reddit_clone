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
<br><br><br><br>
<form action="search.php">
<button type="submit">Search posts</button>
<br><br>
<div id="post_list">
<?php

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
    
	$query = "SELECT id, username, title, reg_date FROM posts ORDER BY reg_date desc";
	$stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    for ($i = 0; $i < sizeof($result); $i++) {
        $postid = $result[$i]["id"];
        echo "<a href='posts.php?postid=$postid'>";
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