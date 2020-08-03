<?php
	require("config.php");
	Session_start();
?>
<head>
	<title>Arvinder's Survey Site</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

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
			<a href="create_survey.php">Create Survey</a>
		</li>
		<li>
			<a href="add_question.php">Edit Surveys</a>
		</li>
		<li>
			<a href="list_surveys.php">List Surveys</a>
		</li>
		<li>
			<a href="logout.php">Logout</a>
		</li>
	</ul>
</nav>