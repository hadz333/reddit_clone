<?php

if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION["username"])) {
	include("navbar_not_signed_in.html");
} else {
	include("navbar_signed_in.php");
}

?>