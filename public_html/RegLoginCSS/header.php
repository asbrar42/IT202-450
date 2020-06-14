<head>
	<title>WEBSITE</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
	require("config.php");
	Session_start();
?>
<nav>
	<ul>
		<li>
			<a href="home.php">Home</a>
		</li>	
		<li>
			<a href="login.php">Login</a>
		</li>
		<li>
			<a href="register.php">Registration</a>
		</li>
		<li>
			<a href="logout.php">Logout</a>
		</li>
	</ul>
</nav>