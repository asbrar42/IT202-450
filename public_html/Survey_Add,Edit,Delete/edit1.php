<?php
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

// Get method on page load.
if(isset($_GET["id"])){
	$thingId = $_GET["id"];
	$stmt = $db->prepare("SELECT * FROM survey where id = :id");
	$stmt->execute([":id"=>$id]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
}

else{
	echo "No id provided in url, don't forget this or sample won't work.";
}
?>

<!-- Post signal -->
<form method="POST">
	<label for="Survey">Survey Title
	<input type="text" id="title" name="title" value="<?php echo get($result, "title");?>"/>
	</label>
	<label for="description"> Description
	<input type="text" id="description" name="description" value="<?php echo get($result, "description");?>"/>
	</label>
	<label> Visibility </label>
	<input type = "radio" name="visibility" value = "1"/> 1
	<input type = "radio" name="visibility" value = "2"/> 2
	<input type="submit" name="updated" value="Update Thing"/>
</form>


<?php
// Post method
if(isset($_POST["updated"])){
    
        $id = $_POST["id"];
		$title = $_POST["title"];
		$description = $_POST["description"];
		$visibility = $_POST["visibility"];
		
		//We only need to check id I think
		if(!empty($id)){
			try{
			    // For instance here, we need to update the items differently
				$stmt = $db->prepare(
				"UPDATE Survey set 
				    , title = :title
				    , description = :description 
				    , visibility = :visibility 
				    where id = :id");
				$result = $stmt->execute(array(
					":title" => $title,
					":description" => $description,
					":visibility" => $visibility,
					":id" => $id //
				));
				$e = $stmt->errorInfo();
				if($e[0] != "00000"){
					echo var_export($e, true);
				}
				else{
					echo var_export($result, true);
					if ($result){
						echo "Successfully editedsurvey: " . $name;
					}	
					else{
						echo "Error editing record";
					}
				}
			}				
			catch (Exception $e){
				echo $e->getMessage();
			}
		}
		else{
			echo "Id can't be empty.";
		}
}		
?>