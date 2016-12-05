<?php

require("common_funcs.php");

$cursor = new page_header("Cloud9 Pharmacy");
$cursor->add_stylesheet("style_index.css");
$cursor->add_stylesheet("https://fonts.googleapis.com/css?family=Poiret+One");
$cursor->export();

$cursor = new jumbotron("img/cloud9.png");
$cursor->export();

standard_nav();

$mysqli = new mysqli($db_ip,$db_user,$db_pass,$db_base);
if ($mysqli->connect_errno) {exit("Cannot connect to MySQL!");}

echo "<div class=\"container\">\r\n";

if (pharmacist_privilege())
{
	$sql = "SELECT CONCAT(customers.firstName,' ',customers.lastName) AS customer,
			medications.name AS medicine,
			typeName AS type,
			refills, pillCount, instructions
			FROM prescriptions AS p
			INNER JOIN customers ON customers.custId = p.custId
			INNER JOIN medications ON medications.medId = p.medId
			INNER JOIN medication_relation AS mr ON mr.medId = p.medId
			INNER JOIN medication_type AS mt ON mt.medTypeId = mr.medTypeId
			WHERE empId IS ";
			
	$res = $mysqli->query($sql . "NULL");

	if ($res != false && $res->num_rows > 0)
	{
		echo "<h1>Unfilled Prescriptions:</h1>\r\n";
		echo "<div class=\"table-responsive\"><table class=\"table\">\r\n";
		echo "<tr><th>Customer:</th><th>Medication:</th><th>Reason:</th><th>Refills:</th><th>Pill Count:</th><th>Instructions:</th></tr>\r\n";
		
		while ($res_set = $res->fetch_assoc())
		{
			echo "<tr><td>" . $res_set["customer"] . "</td><td>" . $res_set["medicine"] . "</td><td>" . $res_set["type"] . "</td>";
			echo "<td>" . $res_set["refills"] . "</td><td>" . $res_set["pillCount"] . "</td><td>" . $res_set["instructions"] . "</td></tr>\r\n";
		}
		
		echo "</table>\r\n</div>\r\n";
	}
	
	$res = $mysqli->query($sql . "NOT NULL");
	
	if ($res != false && $res->num_rows > 0)
	{
		echo "<h1>Fulfilled Prescriptions:</h1>\r\n";
		echo "<div class=\"table-responsive\"><table class=\"table\">\r\n";
		echo "<tr><th>Customer:</th><th>Medication:</th><th>Reason:</th><th>Refills:</th><th>Pill Count:</th><th>Instructions:</th></tr>\r\n";
		
		while ($res_set = $res->fetch_assoc())
		{
			echo "<tr><td>" . $res_set["customer"] . "</td><td>" . $res_set["medicine"] . "</td><td>" . $res_set["type"] . "</td>";
			echo "<td>" . $res_set["refills"] . "</td><td>" . $res_set["pillCount"] . "</td><td>" . $res_set["instructions"] . "</td></tr>\r\n";
		}
		
		echo "</table>\r\n</div>\r\n";
	}
	
	$res->free();
}

echo "</div>\r\n";

$cursor = new page_footer("Cloud9 Pharmacy");
$cursor->export();

$mysqli->close();

?>