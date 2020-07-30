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

<?php
include("header.php");
require("config.php");

if(isset($_POST["created"])){
		$id = $_POST["id"];
		$title = $_POST["title"];
		$description = $_POST["description"];
		$visibility = $_POST["visibility"];
		if(!empty($title) && !empty($description)){
			$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
			try{
				$db = new PDO($connection_string, $dbuser, $dbpass);
				$stmt = $db->prepare("INSERT INTO Survey (id, title, description, visibility) VALUES (:id, :title, :description, :visibility)");
				$result = $stmt->execute(array(
					":id" => $id,
					":title" => $title,
					":description" => $description,
					":visibility" => $visibility
				));
				$e = $stmt->errorInfo();
				if($e[0] != "00000"){
					echo var_export($e, true);
				}
				else{
					echo var_export($result, true);
					if ($result){
						echo "Successfully created Survey" . $name;
					}	
					else{
						echo "Error";
					}
				}
			}				
			catch (Exception $e){
				echo $e->getMessage();
			}
		}
		else{
			echo "Title and Description can't be empty.";
		}		
}			
?>