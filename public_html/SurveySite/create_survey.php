<?php
include("header.php");
require("config.php");


$db = new PDO("mysql:host=$dbhost;dbname=$dbdatabase", $dbuser, $dbpass);

echo "<h1>Create Survey</h1>";

$result = array();
$current_user = $_SESSION['user']['id'];


function get($arr, $key){
	if(isset($arr[$key])){
		return $arr[$key];
	}
	return "";
}

if(isset($_POST["submit"])){
	$title = $_POST["title"];
	$description = $_POST["description"];
	$status = $_POST["status"];

	try{
		$db = new PDO("mysql:host=$dbhost;dbname=$dbdatabase", $dbuser, $dbpass);
		$stmt = $db->prepare("INSERT INTO survey (title, description, status, user_id) VALUES(:title, :description, :status, :user_id)");
		$stmt->execute(array(
			":title" => $title,
			":description" => $description,
			":status" => $status,
			":user_id" => $current_user
		));

		$e = $stmt->errorInfo();
		if($e[0] != "00000"){
			echo var_export($e, true);
		}
		else{
			echo "Successfully created survey: " . $title;
		}
		}				
	catch (Exception $e){
		echo $e->getMessage();
		echo "Error creating survey";
	}
}	

?>
<form method="post">
	<label for="title"> Survey Title</label>
	<input type="text" id="title" name="title" value="<?php echo get($result, "title");?>"/>
	<label for="description"> Description</label>
	<input type="textarea" id="description" name="description" value="<?php echo get($result, "description");?>"/>
	<label> Status </label>
	<select name="status" id="status">
		<option value="draft">Draft</option>
		<option value="private">Private</option>
		<option value="public">Public</option>
	</select>
	<input type="submit" name="submit" value="submit"/>
</form>