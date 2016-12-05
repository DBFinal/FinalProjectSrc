<?php

require("common_funcs.php");

$cursor = new page_header("Cloud9 Pharmacy");
$cursor->add_stylesheet("style_index.css");
$cursor->add_stylesheet("https://fonts.googleapis.com/css?family=Poiret+One");
$cursor->export();

$cursor = new jumbotron("img/cloud9.png");
$cursor->export();

standard_nav();

function decisions()
{
	echo "<br />\r\n";
	echo "<div class=\"container\">\r\n";
	echo "<div class=\"row\">\r\n";
	echo "<div class=\"col-sm-6\">\r\n";
	echo "<a href=\"fulfillPrescription.php\" type=\"button\" class=\"btn btn-lg btn-primary btn-block\" role=\"button\">Fulfill Prescription</a>\r\n";
	echo "</div>\r\n";
	echo "<div class=\"col-sm-6\">\r\n";
	echo "<a href=\"showAllPrescriptions.php\" type=\"button\" class=\"btn btn-lg btn-primary btn-block\" role=\"button\">Show All Prescriptions</a>\r\n";
	echo "</div>\r\n</div>\r\n</div>\r\n";
}

decisions();

$cursor = new page_footer("Cloud9 Pharmacy");
$cursor->export();

?>