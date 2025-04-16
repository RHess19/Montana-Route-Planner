<?php

$user = stripslashes(strip_tags($_POST['username']));
$password = hash("sha256", stripslashes(strip_tags($_POST['password'])));

$mysqli = new mysqli('localhost', 'root', 'mysql', 'montanarouteplanner');

$matchingUsers = mysqli_fetch_array($mysqli -> query("SELECT COUNT(*) FROM `users` WHERE username='$user' AND password='$password';"))[0];

if($matchingUsers == 1)
{
	session_start();
	$_SESSION['username'] = $user;
	header('location:admin.php');
}
else
{
	echo "<script>alert('Please enter a valid username and password.'); window.location.href = 'login.html';</script>";
}

$mysqli -> close();

?>