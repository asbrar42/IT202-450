<?php
include("header.php");
require("config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$id = -1; 
$result = array();

function get($arr, $key){
	if(isset($arr[$key])){
		return $arr[$key];
	}
	return "";
}

//if(isset($_GET["id"])){
	//$id = $_GET["id"];
	//$stmt = $db->prepare("INSERT INTO Survey (id, title, description, visibility) VALUES (:id, :title, :description, :visibility)");
	//$stmt->execute(["id"=>$id]);
	//$result = $stmt->fetch(PDO::FETCH_ASSOC);
}

if(isset($_POST["created"])){
	$id = $_POST["id"];
	$title = $_POST["title"];
	$description = $_POST["description"];
	$visibility = $_POST["visibility"];
	
	$stmt = $db->prepare("INSERT INTO Survey (id, title, description) VALUES (:id, :title, :description)");
	$stmt->execute(["id"=>$id]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
		
	if(!empty($id)){
		try{
			$stmt = $db->prepare(
			"INSERT survey set 
			    , title = :title
			    , description = :description  
			    , visibility = 2 
			    where id = :id");
			    
			$result = $stmt->execute(array(
				":title" => $title,
				":description" => $description,
				":visibility" => 2,
				":id" => $id
			));
				
			$e = $stmt->errorInfo();
			if($e[0] != "00000"){
				echo var_export($e, true);
			}
			else{
				echo var_export($result, true);
				if ($result){
					echo "Successfully created survey: " . $name;
				}	
				else{
					echo "Error creating record";
				}
			}			}				
		catch (Exception $e){
			echo $e->getMessage();
		}
	}
	else{
		echo "Id can't be empty.";
	}
}		
?>

<form method="POST">
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
	<input type="submit" name="Create" value="Create Survey"/>
</form>