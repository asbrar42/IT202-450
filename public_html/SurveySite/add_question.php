<?php
require('header.php');
$survey_id = $_GET['surveyID'];
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
		$question_text = $_POST["question"];
        $answer1 = $_POST["answer1"];
		$answer2 = $_POST["answer2"];
		if (empty($question_text) || empty($answer1) || empty($answer2)){
			echo "Fields cannot be blank!!";
		}
		else{
			try{
				$db = new PDO("mysql:host=$dbhost;dbname=geo7elygwdj932pv", $dbuser, $dbpass);
                $question_stmt = $db->prepare("INSERT INTO questions (question_text, survey_id) VALUES(:question_text, :survey_id)");
				$answer_stmt = $db->prepare("INSERT INTO answers (answer_text, question_id) VALUES(:answer_text, :question_id)");
				$question_stmt->execute(array(
					":question_text" => $question_text,
					":survey_id" => $survey_id
                ));
                $stmt = $db->prepare("SELECT id FROM questions ORDER BY id DESC LIMIT 1");
                $stmt->execute(array("%$query%"));
                $question_id;
                foreach($stmt as $result ){
                    $question_id = $result['id'];
                }
                $answer_stmt->execute(array(
					":answer_text" => $answer1,
					":question_id" => $question_id
                ));
                $answer_stmt->execute(array(
					":answer_text" => $answer2,
					":question_id" => $question_id
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
