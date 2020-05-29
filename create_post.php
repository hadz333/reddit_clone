<!DOCTYPE HTML>  
<html>
<head>
<style>
  .error {
  	color: red;
  }
</style>
<title>Create Post</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php 
include("session_variables.php");
?>

<?php
// define variables and set to empty values
// every time page is reloaded or submit button is clicked, these are initially reset
$title = $body = "";
$titleErr = $bodyErr = "";

// tells whether input is valid
$validInput = true;

// checks to make sure server request used POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // error text only shows up when required field is not entered
  if (empty($_POST["title"])) {
  	$titleErr = "Title is required";
  	$validInput = false;
  } else {
  	$title = $_POST["title"];
  }
  if (empty($_POST["body"])) {
    $bodyErr = "Body text is required";
    $validInput = false;
  } else {
  	$body = $_POST["body"];
  }

  if ($validInput) {
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
	    
	    if ($validInput) {
	    	$query = "INSERT INTO posts (username, title, body) 
	    		VALUES (?, ?, ?)";
	    	$stmt = $conn->prepare($query);
	    	$stmt->execute([$_SESSION["username"], $title, $body]);
	    	// commit the transaction
		    $conn->commit();
		    echo "New post created successfully";
		    header("Location: http://127.0.0.1/phpProjects/reddit_clone/homePage.php");
		}
	} catch(PDOException $e) {
	    // roll back the transaction if something failed
	    $conn->rollback();
	    echo "Error: " . $e->getMessage();
	}
	$conn = null;
  }
}
?>

<h2>Create post</h2>
<div id="signupForm">
<h4 class="error">Required fields: *</h4> 
<!-- $_SERVER["PHP_SELF"] returns your current file name --> 
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
Title: <input type="text" name="title" value="<?php echo $title;?>" maxlength="50">
<!-- span below will only contain "*" (indicating required field) unless error exists -->
<span class="error">* <?php echo $titleErr;?></span>
<br><br>
Body: <textarea id="body" name="body" rows="5" cols="50"><?php echo $body;?></textarea>
<span class="error">* <?php echo $bodyErr;?></span>
<br><br>
<input type="submit" name="submit" value="Post">
</form>
</div>
</body>
</html>