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
  if (empty($_POST["username"])) {
  	$usernameErr = "Username is required";
  	$validInput = false;
  } else {
  	$username = test_input($_POST["username"]);
  	// if name isn't valid, set error text (not blank anymore)
	if (!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
	  $usernameErr = "Only letters and numbers allowed";
	  $validInput = false;
	}

  }
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
    $validInput = false;
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  		$emailErr = "Invalid email format";
  		$validInput = false;
	}
  }
  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
    $validInput = false;
  } else {
    $password = test_input($_POST["password"]);
    if (!validate_password($password)) {
    	$validInput = false;
  		$passwordErr = "Password must be 6 characters or greater, include 1 Uppercase letter (A-Z) and 1 Number (0-9)";
	}
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
	    // our SQL statements
	    // ensure username and email don't already exist in database
	    $nameDBcheck = $conn->prepare("SELECT * FROM users WHERE username=?");
	    $nameDBcheck->execute([$username]);
	    $result = $nameDBcheck->fetch();
	    if ($result) {
	    	$usernameErr = "Username already exists";
	    	$validInput = false;
	    }

	    $emailDBcheck = $conn->prepare("SELECT * FROM users WHERE email=?");
	    $emailDBcheck->execute([$email]);
	    $result = $emailDBcheck->fetch();
	    if ($result) {
	    	$emailErr = "Email already exists";
	    	$validInput = false;
	    } 
	    if ($validInput) {
	    	$query = "INSERT INTO users (username, password, email) 
	    		VALUES (?, ?, ?)";
	    	$stmt = $conn->prepare($query);
	    	$stmt->execute([$username, $password, $email]);
	    	// commit the transaction
		    $conn->commit();
		    echo "New user created successfully";
		    header("Location: http://127.0.0.1/phpProjects/reddit_clone/login_page.php");
		}

	    
	    }
	catch(PDOException $e)
	    {
	    // roll back the transaction if something failed
	    $conn->rollback();
	    echo "Error: " . $e->getMessage();
	    }

	$conn = null;
  }
}

function validate_password($str) {
	if (strlen($str) >= 6) {
		if(preg_match('/[A-Z]/', $str)){
 			// There is one uppercase letter
 			if(preg_match('/[0-9]/', $str)){
 			// There is one number
 				return true;
			}
		}
	}
	return false;
}

/* 
What is the htmlspecialchars() function?
The htmlspecialchars() function converts special characters to HTML entities. This means that it will replace HTML characters like < and > with &lt; and &gt;. This prevents attackers from exploiting the code by injecting HTML or Javascript code (Cross-site Scripting attacks) in forms.
*/
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Create post</h2>
<div id="signupForm">
<h4 class="error">Required fields: *</h4> 
<!-- $_SERVER["PHP_SELF"] returns your current file name --> 
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
Title: <input type="text" name="title" value="<?php echo $title;?>">
<!-- span below will only contain "*" (indicating required field) unless error exists -->
<span class="error">* <?php echo $titleErr;?></span>
<br><br>
Body: <textarea id="body" name="body" rows="5" cols="50"><?php echo $body;?></textarea>
<span class="error">* <?php echo $bodyErr;?></span>
<br>
<input type="submit" name="submit" value="Add Post">
</form>
</div>
</body>
</html>