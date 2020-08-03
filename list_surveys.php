<?php
require('header.php');

$current_user = $_SESSION['user']['id'];
$db = new PDO("mysql:host=$dbhost;dbname=$dbdatabase", $dbuser, $dbpass);
echo "<h1>Surveys</h1>";
if (isset($current_user)) {
    try{
        $stmt = $db->prepare("SELECT id, title FROM survey WHERE status!='public' AND user_id=$current_user");
        $stmt->execute(array("%$query%"));
        foreach($stmt as $result ){
            echo "<ul>";
            echo "<li>".$result['title']."</li><a href='add_question.php?surveyID=".$result['id']."'>Add Question</a>";
            echo "</ul>";
        }
        }				
    catch (Exception $e){
        echo $e->getMessage();
        echo "Error listing surveys";
    }    
} else{
    try{
        $stmt = $db->prepare("SELECT id, title FROM survey WHERE status='public'");
        $stmt->execute(array("%$query%"));
        foreach($stmt as $result ){
            echo "<ul>";
            echo "<li>".$result['title']."</li><a href='add_question.php?surveyID=".$result['id']."'>Add Question</a><br>";
            echo "<a href='view_survey.php?surveyID=".$result['id']."'>View Survey</a><br>";
            echo "<a href='delete_survey.php?surveyID=".$result['id']."'>Delete Survey</a>";
            echo "</ul>";
        }
        }				
    catch (Exception $e){
        echo $e->getMessage();
        echo "Error listing surveys";
    }   
}
?>