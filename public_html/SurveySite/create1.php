<?php
include("header.php");
require("config.php");

$db = new PDO("mysql:host=$dbhost;dbname=geo7elygwdj932pv", $dbuser, $dbpass);
$id = -1; 
$result = array();

function get($arr, $key){
	if(isset($arr[$key])){
		return $arr[$key];
	}
	return "";
}

if(isset($_POST["created"])){
	$id = $_POST["id"];
	$title = $_POST["title"];
	$description = $_POST["description"];
	$visibility = $_POST["visibility"];

	if(!empty($id) && !empty($title) && !empty($description)){
			try{
				$db = new PDO("mysql:host=$dbhost;dbname=geo7elygwdj932pv", $dbuser, $dbpass);
				$stmt = $db->prepare("INSERT INTO Survey (id, title, description, visibility) VALUES (:id, :title, :description, :visibility)");
				$stmt->execute(array(
				":title" => $title,
				":description" => $description,
				":visibility" => $visibility,
				":id" => $id
				));

				$e = $stmt->errorInfo();
				if($e[0] != "00000"){
					echo var_export($e, true);
					echo "\n\nError in creating survey";
				}
				else{
					echo "Successfully created survey: " . $title;
				}
			}				
			catch (Exception $e){
				echo $e->getMessage();
			}
	}
	
	else{
		echo "ERROR! ID, Title, and Description cannot be empty.";
	}
}

?>

<form method="post">
    <label for="id"> Id
    <input type="number" id="id" name="id"/>
    </label>
	<label for="title"> Survey Title
	<input type="text" id="title" name="title" value="<?php echo get($result, "title");?>"/>
	</label>
	<label for="description"> Description
	<input type="text" id="description" name="description" value="<?php echo get($result, "description");?>"/>
	</label>
	<label> Visibility </label>
	<input type = "radio" name="visibility" value = "1"/> 1
	<input type = "radio" name="visibility" value = "2"/> 2
	<input type="submit" name="created" value="Create Survey"/>
</form>