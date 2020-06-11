<?php
Session_start();
echo "welcome, " . $_SESSION["user"]["email"];
?>
<a href="logout.php">Logout</a>