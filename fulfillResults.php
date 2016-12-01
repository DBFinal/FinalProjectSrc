<?php

require("common_funcs.php");

$cursor = new page_header("Cloud9 Pharma");
$cursor->add_stylesheet("style_index.css");
$cursor->add_stylesheet("https://fonts.googleapis.com/css?family=Poiret+One");
$cursor->export();

$cursor = new jumbotron("img/cloud9.png");
$cursor->export();

standard_nav();

echo "<div class=\"container\">\r\n";
echo "<h1>Prescription Result</h1>\r\n";
echo "<div class=\"well\">\r\n";

if (isset($_POST["submit"]))
{
	$mysqli = new mysqli($db_ip,$db_user,$db_pass,$db_base);
	if ($mysqli->connect_errno) {exit("Cannot connect to MySQL!");}

	
	$sql = "SELECT * FROM Prescriptions WHERE custId = '" . $_POST["customerid"] . "' AND empId = 'NULL' ORDER BY prescripId LIMIT 1";
	$res = $mysqli->query($sql);
	
	if ($res != false)
	{
		if ($res->num_rows > 0)
		{
			$res_set = $res->fetch_assoc();
			
			echo $res_set["instructions"];
		}
		else
		{
			//Prescription filled already or none avialable.
		}
	}
	else
	{
		//SQL error.
	}
	
	$mysqli->close();
}



echo "</div>\r\n</div>\r\n";

$cursor = new page_footer("Cloud 9 Pharma");
$cursor->export();

?>