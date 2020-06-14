<?php
include("header.php");
?>
<h4>LOGIN</h4>
<form method="POST">
	<label for="email">Email
	<input type="email" id="email" name="email"/>
	</label>
	<label for="p">Password
	<input type="password" id="p" name="password"/>
	</label>
	<input type="submit" name="login" value="Login"/>
</form>

<?php
//Session_start(); //Sessions Folder version has this line in it and SampleRegLogin does not
//echo var_export($_GET, true);
//echo var_export($_POST, true);
//echo var_export($_REQUEST, true);
if(isset($_POST["login"])){
	if(isset($_POST["password"]) && isset($_POST["email"])){
		$password = $_POST["password"];
		$email = $_POST["email"];
			//require("config.php");
			$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
			$email = test_input($_POST["email"]);
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$emailErr = "Incorrect email format";
				echo $emailErr;
			}
			else (empty($email) || empty($password)){
				echo "Email and password fields cannot be blank";
			}
			try{
				$db = new PDO($connection_string, $dbuser, $dbpass);
				$stmt = $db->prepare("SELECT * FROM Users where email = :email LIMIT 1");
				$stmt->execute(array(
					":email" => $email
				));
				$e = $stmt->errorInfo();
				if($e[0] != "00000"){
					echo var_export($e, true);
				}
				else{
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($result){
						$rpassword = $result["password"];
						if(password_verify($password, $rpassword)){
							echo "<div>Passwords matched! You're technically logged in!</div>";
							$_SESSION["user"] = array(
								"id"=>$result["id"],
								"email"=>$result["email"],
								"first_name"=>$result["first_name"],
								"last_name"=>$result["last_name"]
							);
							echo var_export($_SESSION, true);
							//header( string: "Location: home.php");
						}
						else{
							echo "<div>Invalid password!</div>";
						}
					}
					else{
						echo "<div>Invalid user</div>";
					}	
					//echo "<div>Successfully registered!</div>";
				}
			}				
			catch (Exception $e){
				echo $e->getMessage();
			}
		}
		else{
			echo "<div>Passwords don't match</div>";
		}
	}
?>