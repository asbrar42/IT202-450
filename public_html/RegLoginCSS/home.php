<?php include("header.php"); ?>
<h1>Homepage</h1>
<?php
echo "\nWelcome, " . $_SESSION["user"]["email"];
?>