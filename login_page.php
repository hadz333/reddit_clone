<!DOCTYPE html>
<html>
<head>
	<title>Log in to Reddit 2</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php 

$username = $password = "";
$usernameErr = $passwordErr = "";

include("session_variables.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// retrieve user from database, check if password is correct.
	// if user not found, provide error message that the user does not exist.

	$servername = "localhost";
	$db_user = "root";
	$db_password = "";
	$dbname = "RedditCloneDB";

	$username = $_POST["username"];
	$password = $_POST["password"];

	try {
	    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_user, $db_password);
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    // begin the transaction
	    $conn->beginTransaction();
	    // our SQL statements
	    // ensure username and email don't already exist in database
	    $nameDBcheck = $conn->prepare("SELECT password FROM users WHERE username=?");
	    $nameDBcheck->execute([$username]);
	    $result = $nameDBcheck->fetch();
	    if ($result) {
	    	// user exists, validate password
	    	if ($password == $result[0]) {
	    		echo "Logged in successfully";
	    		session_start();
	    		$_SESSION["username"] = $username;
	    		session_write_close();
		    	header("Location: http://127.0.0.1/phpProjects/reddit_clone/homePage.php");
	    	} else {
	    		$passwordErr = "Password is incorrect.";
	    	}
	    } else {
	    	$usernameErr = "User does not exist.";
	    }
	} catch(PDOException $e) {
	    // roll back the transaction if something failed
	    $conn->rollback();
	    echo "Error: " . $e->getMessage();
	}
	$conn = null;
}

?>
<h3> Reddit 2 </h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
  Username: <input type="text" name="username" value="<?php echo $username;?>"> <?php echo $usernameErr;?>
  <br>
  Password: <input type="password" name="password" value="<?php echo $password;?>"> <?php echo $passwordErr;?>
  <br>
  <input type="submit" value="Sign in">
  <br><br>
  Don't have an account? <a href="signup_page.php">Sign up</a>
</form>
</body>
</html>