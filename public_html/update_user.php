<?php
require("config.php");

$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
try{
	$db = new PDO($connection_string, $dbuser, $dbpass);
	$stmt = $db->prepare("UPDATE Users set email=: WHERE email = :original");
	$stmt->bindvalue(":email","newemail@test.com");
	$stmt->bindvalue(":original","test@test.com");
	$r = $stmt->execute();
	
	echo var_export($stmt->errorInfo(), true);
	echo var_export($r, true);
}
catch (Exception $e){
	echo $e->getMessage();
}
?>