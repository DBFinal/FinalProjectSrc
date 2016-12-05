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

$sql = "SELECT * FROM customers";
$res = $mysqli->query($sql);

echo "<h1>Customer Data:</h1>\r\n";
echo "<div class=\"table-responsive\"><table class=\"table\">\r\n";
echo "<tr><th>ID:</th><th>First Name:</th><th>Last Name:</th><th>Phone:</th><th>Email:</th>";
echo "<th>Address:</th><th>City:</th><th>State:</th><th>Zip:</th></tr>\r\n";

if ($res != false && $res->num_rows > 0)
{
	while ($res_set = $res->fetch_assoc())
	{
		echo "<tr><td>" . $res_set["custId"] . "</td><td>" . $res_set["firstName"] . "</td><td>" . $res_set["lastName"] . "</td>";
		echo "<td>" . $res_set["phone"] . "</td><td>" . $res_set["email"] . "</td><td>" . $res_set["address"] . "</td>";
		echo "<td>" . $res_set["city"] . "</td><td>" . $res_set["state"] . "</td><td>" . $res_set["zipCode"] . "</tr>\r\n";
	}
}

echo "</table>\r\n</div>\r\n</div>\r\n";

$cursor = new page_footer("Cloud9 Pharmacy");
$cursor->export();

?>