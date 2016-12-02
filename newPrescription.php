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
	if (doctor_privilege())
	{
		$customer_id = $_POST["customerid"];
		$medication_id = $_POST["medicationid"];
		$pill_count = $_POST["pillcount"];
		$refill = $_POST["refill"];
		$instructions = trim($_POST["instructions"]);
		$doctor = $_SESSION["logpersonid"];
		
		$stmt = $mysqli->prepare("INSERT INTO Prescriptions VALUES (NULL, ?, ?, NULL, ?, ?, ?, ?)");
		$stmt->bind_param("iiiiis", $doctor, $customer_id, $medication_id, $refill, $pill_count, $instructions);
		$res = $stmt->execute();
		
		if ($res)
		{
			result_message("success","Prescription successfully created!","info");
		}
		else
		{
			result_message("failure","Prescription could not be created!","danger");
		}
		
		$stmt->close();
	}
	else
	{
		result_message("problem","You cannot create prescriptions, check your login!","warning");
	}
}

?>

<div class="well">
<form class="form-horizontal" method="POST" action="newPrescription.php">
<div class="form-group">
<label class="control-label col-sm-3" for="customerid">Customer ID:</label>
<div class="col-sm-9">
<?php

//<input type="number" class="form-control" id="customerid" name="customerid" required />

$cursor = new drop_down_menu("customerid");

$sql = "SELECT custId, CONCAT(custId, ' - ', firstName, ' ', lastName) AS name FROM customers;";
$res = $mysqli->query($sql);

if ($res != false && $res->num_rows > 0)
{
	while ($res_set = $res->fetch_assoc())
	{
		$cursor->add_item($res_set["name"],$res_set["custId"]);
	}
}

$cursor->export();
$res->free();

?>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="medicationid">Medication ID:</label>
<div class="col-sm-9">
<?php

$cursor = new drop_down_menu("medicationid");

$sql = "SELECT medId, name FROM medications";
$res = $mysqli->query($sql);

if ($res != false && $res->num_rows > 0)
{
	while ($res_set = $res->fetch_assoc())
	{
		$cursor->add_item($res_set["name"],$res_set["medId"]);
	}
}

$cursor->export();
$res->free();

?>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="pillcount">Pill Count:</label>
<div class="col-sm-9">
<input type="number" class="form-control" id="pillcount" name="pillcount" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="refill">How many refills?</label>
<div class="col-sm-9">
<input type="number" class="form-control" id="refill" name="refill" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="instructions">Instructions:</label>
<div class="col-sm-9">
<input type="text" class="form-control" id="instructions" name="instructions" pattern="[a-zA-Z0-9\s]+" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="submit">&nbsp;</label>
<div class="col-sm-9">
<button type="submit" id="submit" name="submit" class="btn btn-primary">Create Prescription</button>
</div>
</div>
</form>
<img src="img/pill.png" alt="PILLS" style="width:112px;">
</div>

<?php

echo "</div>\r\n";

$cursor = new page_footer("Cloud 9 Pharma");
$cursor->export();

$mysqli->close();

?>