<?php

session_start();

$_SESSION["loggedin"] = false;
unset($_SESSION["loguser"]);
unset($_SESSION["logid"]);
unset($_SESSION["logpersonid"]);
unset($_SESSION["logjob"]);

header("Location:/c9/finalprojectsrc/index.php");

?>