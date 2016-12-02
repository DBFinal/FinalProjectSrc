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
echo "<h1>Prescription</h1>\r\n";

$mysqli = new mysqli($db_ip,$db_user,$db_pass,$db_base);
if ($mysqli->connect_errno) {exit("Cannot connect to MySQL!");}

if (isset($_POST["submit"]))
{
	$sql = "SELECT
			prescriptions.prescripId AS pid,
			CONCAT(doctors.firstName,' ',doctors.lastName,' ',licenseNo) AS doctor,
			CONCAT(customers.firstName,' ',customers.lastName) AS customer,
			customers.phone AS phone,
			refills,
			pillCount,
			instructions,
			clinic,
			medications.name AS medicine,
			supplyQuantity
			FROM prescriptions
			INNER JOIN doctors ON doctors.doctId = prescriptions.doctId
			INNER JOIN customers ON customers.custId = prescriptions.custId
			INNER JOIN medications ON medications.medId = prescriptions.medId
			WHERE prescriptions.empId IS NULL AND prescriptions.custId = '" . $_POST["customerid"] . "'";
			
	$res = $mysqli->query($sql);
	
	if ($res != false)
	{
		if ($res->num_rows > 0)
		{
			$res_set = $res->fetch_assoc();
			echo "<div class=\"well\">\r\n";
			echo "<kbd>Customer:</kbd> " . $res_set["customer"] . "<br />\r\n";
			echo "<kbd>Customer's Phone:</kbd> " . $res_set["phone"] . "<br />\r\n";
			echo "<kbd>Doctor:</kbd> " . $res_set["doctor"] . "<br />\r\n";
			echo "<kbd>Clinic:</kbd> " . $res_set["clinic"] . "<br />\r\n";
			echo "<kbd>Medicine:</kbd> " . $res_set["medicine"] . "<br />\r\n";
			echo "<kbd>Instructions:</kbd> " . $res_set["instructions"] . "<br />\r\n";
			echo "<kbd>Supply Quantity:</kbd> " . $res_set["supplyQuantity"] . "<br />\r\n";
			echo "<kbd>Pill Count:</kbd> " . $res_set["pillCount"] . "<br />\r\n";
			echo "<kbd>Refills:</kbd> " . $res_set["refills"] . "<br />\r\n<br />\r\n";
			echo "<form method=\"POST\" action=\"" . $_SERVER["PHP_SELF"] . "\">\r\n";
			echo "<button type=\"submit\" id=\"fulfill\" name=\"fulfill\" class=\"btn btn-info\">Fulfill</button>\r\n";
			echo "</form>\r\n";
			echo "</div>\r\n";
			
			$_SESSION["prescript"] = $res_set["pid"]; //Communicates with fulfill form action below.
		}
		else
		{
			result_message("problem","Prescription not found!","warning");
		}
	}
	else
	{
		result_message("error","There exists an error in the SQL query!","danger");
	}
}

if (isset($_POST["fulfill"]) && isset($_SESSION["prescript"]))
{
	if (pharmacist_privilege())
	{
		$sql = "UPDATE prescriptions SET empId = '" . $_SESSION["logpersonid"] . "' WHERE prescripId = '" . $_SESSION["prescript"] . "'";
		$res = $mysqli->query($sql);
		
		if ($res != false)
		{
			result_message("success","Prescription has been fulfilled!","success");
		}
		else
		{
			result_message("error","Could not fulfill prescription!","danger");
		}
	}
	else
	{
		result_message("problem","You cannot fulfill prescriptions, check your login!","warning");
	}
	
	unset($_SESSION["prescript"]);
}

$mysqli->close();

?>

<div class="well">
<form class="form-horizontal" method="POST" action="fulfillPrescription.php">
<div class="form-group">
<label class="control-label col-sm-3" for="customerid">Customer ID:</label>
<div class="col-sm-9">
<input type="number" class="form-control" id="customerid" name="customerid" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="submit">&nbsp;</label>
<div class="col-sm-9">
<button type="submit" id="submit" name="submit" class="btn btn-primary">Search</button>
</div>
</div>
</form>
</div>

<?php

echo "</div>\r\n";

$cursor = new page_footer("Cloud 9 Pharma");
$cursor->export();

?>