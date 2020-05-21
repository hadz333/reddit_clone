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


if (isset($_SESSION["username"])) {
	echo "<a href='create_post.php'>+ Create post</a>";
} else {
	echo "<a href='login_page.php'>+ Create post</a>";
}

echo "<br><br>";

if (empty($_GET["postid"])) {
echo "<h2>Posts</h2>";

echo "<table style='border: solid 0px black;'>";
echo "<tr><th>Author</th><th>Title</th><th>Posted</th></tr>";

class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td style='width:150px;border:0px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }

    function endChildren() {
        echo "</tr>" . "\n";
    }
}

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
    
    $query = "SELECT username, title, reg_date FROM posts";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        echo $v;
    }
} catch(PDOException $e) {
    // roll back the transaction if something failed
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
} else {
    // If postid=? is in the URL, we will be here and use that ? value to serve the post with this id.
    $postid = $_GET["postid"];
    // retrieve post with id requested from the database
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

        $query = "SELECT username, title, body, reg_date FROM posts WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$postid]);
        // set the resulting array to associative
        $result = $stmt->fetch();

        // if postid does not exist in database, show error message. Otherwise, show the post.
        if (empty($result)) {
            echo "Sorry, this post does not exist.";
        } else {
            echo "<h2>", $result[1], "</h2>";
            echo "Author: ", $result[0], "<br>";
            echo "Posted: ", $result[3], "<br>";
            echo "<p>", $result[2], "</p>";
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
</body>
</html>