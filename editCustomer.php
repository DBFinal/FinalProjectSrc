<?php

require("common_funcs.php");

$cursor = new page_header("Cloud9 Pharmacy");
$cursor->add_stylesheet("style_index.css");
$cursor->add_stylesheet("https://fonts.googleapis.com/css?family=Poiret+One");
$cursor->export();

$cursor = new jumbotron("img/cloud9.png");
$cursor->export();

standard_nav();

function form_field($type, $name, $label, $value)
{
	echo "<div class=\"form-group\">\r\n";
	echo "<label class=\"control-label col-sm-3\" for=\"" . $name . "\">" . $label . "</label>\r\n";
	echo "<div class=\"col-sm-9\">\r\n";
	echo "<input type=\"" . $type . "\" class=\"form-control\" value=\"" . $value . "\" id=\"" . $name . "\" name=\"" . $name . "\" required />\r\n";
	echo "</div>\r\n</div>\r\n";
}

$mysqli = new mysqli($db_ip,$db_user,$db_pass,$db_base);
if ($mysqli->connect_errno) {exit("Cannot connect to MySQL!");}

echo "<div class=\"container\">\r\n";
echo "<h1>Edit Customer:</h1>\r\n";
echo "<div class=\"well\">\r\n";

if (isset($_POST["update"]))
{
	$sql = "UPDATE Customers SET "
		. "firstName = '" . $_POST["firstname"] . "', "
		. "lastName = '" . $_POST["lastname"] . "', "
		. "phone = '" . $_POST["phone"] . "', "
		. "email = '" . $_POST["email"] . "', "
		. "address = '" . $_POST["address"] . "', "
		. "city = '" . $_POST["city"] . "', "
		. "state = '" . $_POST["state"] . "', "
		. "zipCode = '" . $_POST["zip"] . "' ";
		
	if (isset($_SESSION["customer"]))
	{
		$sql .= "WHERE custId = '" . $_SESSION["customer"] . "'";
		unset($_SESSION["customer"]);
	}
	else
	{
		$sql .= "WHERE 0";
	}
	
	$res = $mysqli->query($sql);
	
	if ($res == false)
	{
		result_message("error","Could not update customer, check query!","danger");
	}
	else
	{
		result_message("success","Customer successfully updated!","info");
	}
}

echo "<form class=\"form-horizontal\" method=\"POST\" action=\"" . $_SERVER["PHP_SELF"] . "\">\r\n";
echo "<div class=\"form-group\">\r\n";
echo "<label class=\"control-label col-sm-3\" for=\"change\">Change to:</label>\r\n";
echo "<div class=\"col-sm-9\">\r\n";

$firstname = "";
$lastname = "";
$phone = "";
$email = "";
$address = "";
$city = "";
$state = "";
$zip = "";

if (isset($_POST["change"]))
{
	$sql = "SELECT * FROM Customers WHERE custId = '" . $_POST["customerid"] . "'";
	$res = $mysqli->query($sql);
	
	if ($res != false && $res->num_rows == 1)
	{
		$res_set = $res->fetch_assoc();
		
		$firstname = $res_set["firstName"];
		$lastname = $res_set["lastName"];
		$phone = $res_set["phone"];
		$email = $res_set["email"];
		$address = $res_set["address"];
		$city = $res_set["city"];
		$state = $res_set["state"];
		$zip = $res_set["zipCode"];
	}
	
	$_SESSION["customer"] = $_POST["customerid"];
}

$cursor = new drop_down_menu("customerid");

$sql = "SELECT custId, CONCAT(custId,' - ',firstName,' ',lastName) AS name FROM Customers";
$res = $mysqli->query($sql);

$cursor->add_item("Nobody","-1");

if ($res != false && $res->num_rows > 0)
{
	while ($res_set = $res->fetch_assoc())
	{
		$i = $cursor->add_item($res_set["name"], $res_set["custId"]);
	}
	
	$res->free();
}

$cursor->export();

echo "</div>\r\n</div>\r\n";
echo "<div class=\"form-group\">\r\n";
echo "<label class=\"control-label col-sm-3\" for=\"change\">&nbsp;</label>\r\n";
echo "<div class=\"col-sm-9\">\r\n";
echo "<button type=\"submit\" id=\"change\" name=\"change\" class=\"btn btn-info\">Change</button>\r\n";
echo "</div>\r\n</div>\r\n";
echo "</form>\r\n<br />\r\n";
echo "<form class=\"form-horizontal\" method=\"POST\" action=\"" . $_SERVER["PHP_SELF"] . "\">\r\n";

form_field("text","firstname","First Name:",$firstname);
form_field("text","lastname","Last Name:",$lastname);
form_field("number","phone","Phone:",$phone);
form_field("email","email","Email:",$email);
form_field("text","address","Address:",$address);
form_field("text","city","City:",$city);
form_field("text","state","State:",$state);
form_field("number","zip","Zip:",$zip);
	
echo "<div class=\"form-group\">\r\n";
echo "<label class=\"control-label col-sm-3\" for=\"update\">&nbsp;</label>\r\n";
echo "<div class=\"col-sm-9\">\r\n";
echo "<button type=\"submit\" id=\"update\" name=\"update\" class=\"btn btn-info\">Update</button>\r\n";
echo "</div>\r\n</div>\r\n";
echo "</form>\r\n";
echo "</div>\r\n</div>\r\n";

$cursor = new page_footer("Cloud9 Pharmacy");
$cursor->export();

$mysqli->close();

?>