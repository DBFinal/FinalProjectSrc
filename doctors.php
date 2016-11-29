<?php

require("common_funcs.php");

$cursor = new page_header("Cloud9 Pharma");
$cursor->add_stylesheet("style_index.css");
$cursor->add_stylesheet("https://fonts.googleapis.com/css?family=Poiret+One");
$cursor->export();

$cursor = new jumbotron("img/cloud9.png");
$cursor->export();

standard_nav();

?>
<style>
.button1 {
    background-color: #5E548E;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 40px 2px;
    cursor: pointer;
	margin-left:220px;
	float:left
}
.button2 {
    background-color: #5E548E;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 40px 2px;
    cursor: pointer;
	margin-right:220px;
	float:right
}
</style>
<html>
<body>
<form action="newPrescription.php">
<button class="button1">Create New Prescription</button>
</form>
<form action="showCurrent.php">
<button class="button2">Show Current Prescriptions</button>
</form>
</body>
</html>
<?php
$cursor = new page_footer("Cloud 9 Pharma");
$cursor->export();

?>