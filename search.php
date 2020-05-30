<!DOCTYPE html>
<html lang="en">
<head>
  <title>Posts</title>
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
echo "<br><br>";
?>

<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<input type="text" name="searchText" placeholder="Search..."><button type="submit" style="margin-left:5px;">Search</button>
</form>
<div id="post_list">
<?php

// search handling
if (!empty($_GET['searchText'])) {
    // return all post titles that include search query
    $servername = "localhost";
    $db_user = "root";
    $db_password = "";
    $dbname = "RedditCloneDB";

    $searchText = $_GET['searchText'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_user, $db_password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // begin the transaction
        $conn->beginTransaction();
        
        $query = "SELECT id, username, title, reg_date FROM posts WHERE title like '%$searchText%' ORDER BY reg_date desc";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        for ($i = 0; $i < sizeof($result); $i++) {
            $postid = $result[$i]["id"];
            echo "<a href='./posts.php?postid=$postid'>";
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
}
?>
</div>
</div>
</body>
</html>