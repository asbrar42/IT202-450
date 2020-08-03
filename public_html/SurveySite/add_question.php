<?php
require('header.php');
$surveyID = $_GET['surveyID'];
?>

<h1>Add Questions to Survey</h1>
<form method="POST">
	<label for="question">Question
	<input type="text" name="question"/>
	</label>
	<label for="answer1">Answer one
	<input type="text" name="answer1"/>
    <label for="answer2">Answer two
	<input type="text" name="answer2"/>
	</label>
	<input type="submit" name="question_form" value="Submit Question"/>
</form>

<?php 
if(isset($_POST["question_form"])){
	if(isset($_POST["question"]) && isset($_POST["answer1"]) && isset($_POST["answer2"])){
		$questionText = $_POST["question"];
        $answer1 = $_POST["answer1"];
		$answer2 = $_POST["answer2"];
		if (empty($questionText) || empty($answer1) || empty($answer2)){
			echo "Fields cannot be blank!!";
		}
		else{
			try{
				$db = new PDO("mysql:host=$dbhost;dbname=$dbdatabase", $dbuser, $dbpass);
                $question_stmt = $db->prepare("INSERT INTO questions1 (questionText, surveyID) VALUES(:questionText, :surveyID)");
				$answer_stmt = $db->prepare("INSERT INTO answers1 (answerText, questionID) VALUES(:answerText, :questionID)");
				$question_stmt->execute(array(
					":questionText" => $questionText,
					":surveyID" => $surveyID
                ));
                $stmt = $db->prepare("SELECT surveyID FROM questions1 ORDER BY surveyID DESC LIMIT 1");
                $stmt->execute(array("%$query%"));
                $questionID;
                foreach($stmt as $result ){
                    $questionID = $result['id'];
                }
                $answer_stmt->execute(array(
					":answerText" => $answer1,
					":questionID" => $questionID
                ));
                $answer_stmt->execute(array(
					":answerText" => $answer2,
					":questionID" => $questionID
				));
				$e = $stmt->errorInfo();
				
				if($e[0] != "00000"){
					echo var_export($e, true);
				}
				else{
					echo "<div>Successfully added question!</div>";
				}
			}				
			catch (Exception $e){
				echo $e->getMessage();
			}
		}
	}
}
?>
