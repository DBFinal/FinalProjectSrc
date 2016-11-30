<?php

require("common_funcs.php");

$cursor = new page_header("Cloud9 Pharma");
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
	echo "<a href=\"newPrescription.php\" type=\"button\" class=\"btn btn-lg btn-primary btn-block\" role=\"button\">Create New Prescription</a>\r\n";
	echo "</div>\r\n";
	echo "<div class=\"col-sm-6\">\r\n";
	echo "<a href=\"showCurrent.php\" type=\"button\" class=\"btn btn-lg btn-primary btn-block\" role=\"button\">Show Current Prescriptions</a>\r\n";
	echo "</div>\r\n</div>\r\n</div>\r\n";
}

//if (doctor_privilege()) //Deploy this when we're almost done with the project. This is the permissions system.
//{
decisions();
//}

$cursor = new page_footer("Cloud 9 Pharma");
$cursor->export();

?>