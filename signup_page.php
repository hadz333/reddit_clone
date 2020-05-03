<!DOCTYPE HTML>  
<html>
<head>
<style>
  .error {
  	color: red;
  }
  #signupForm {
  	margin-left: 20%;
  }
</style>
<title>Sign up for Reddit 2</title>
<link rel="stylesheet" type="text/css" href="styles.css">
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

<?php
// define variables and set to empty values
// every time page is reloaded or submit button is clicked, these are initially reset
$username = $email = $password = "";
$usernameErr = $emailErr = $passwordErr = "";

// checks to make sure server request used POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // error text only shows up when required field is not entered
  if (empty($_POST["username"])) {
  	$usernameErr = "Username is required";
  } else {
  	$username = test_input($_POST["username"]);
  	// if name isn't valid, set error text (not blank anymore)
	if (!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
	  $usernameErr = "Only letters and numbers allowed";
	}

	// TODO: Check if username already exists

  }
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  		$emailErr = "Invalid email format";
	}

	// TODO: Check if email already exists
	
  }
  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else {
    $password = test_input($_POST["password"]);
    if (!validate_password($password)) {
  		$passwordErr = "Password must be 6 characters or greater, include 1 Uppercase letter (A-Z) and 1 Number (0-9)";
	}
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

<center><h2>Sign up for Reddit 2</h2></center>
<div id="signupForm">
<h4 class="error">Required fields: *</h4> 
<!-- $_SERVER["PHP_SELF"] returns your current file name --> 
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
Username: <input type="text" name="username" value="<?php echo $username;?>">
<!-- span below will only contain "*" (indicating required field) unless error exists -->
<span class="error">* <?php echo $usernameErr;?></span>
<br><br>
<!-- value is set to $_____, which allows data to remain in boxes after submitting -->
E-mail: <input type="text" name="email" value="<?php echo $email;?>">
<span class="error">* <?php echo $emailErr;?></span>
<br><br>
Password: <input type="password" name="password" value="<?php echo $password;?>">
<span class="error">* <?php echo $passwordErr;?></span>
<br>
<input type="submit" name="submit" value="Sign up">

</form>
</div>
<?php
echo "<h2>Your Input:</h2>";
echo $username;
echo "<br>";
echo $email;
echo "<br>";
echo $password
?>

</body>
</html>