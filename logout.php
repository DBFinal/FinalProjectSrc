<?php

session_start();

$_SESSION["loggedin"] = false;
unset($_SESSION["loguser"]);
unset($_SESSION["logid"]);
unset($_SESSION["logpersonid"]);
unset($_SESSION["logisdoctor"]);
unset($_SESSION["logispharmacist"]);

header("Location:/c9/finalprojectsrc/index.php");

?>