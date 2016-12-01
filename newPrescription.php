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

if (isset($_POST["submit"]))
{	
	$mysqli = new mysqli($db_ip,$db_user,$db_pass,$db_base);
	if ($mysqli->connect_errno) {exit("Cannot connect to MySQL!");}
	
	$customer_id = $_POST["customerid"];
	$medication_id = $_POST["medicationid"];
	$pill_count = $_POST["pillcount"];
	$refill = $_POST["refill"];
	$instructions = trim($_POST["instructions"]);
	$doctor = $_POST["doctor"];
	
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
	$mysqli->close();
}

?>

<div class="well">
<form class="form-horizontal" method="POST" action="newPrescription.php">
<div class="form-group">
<label class="control-label col-sm-3" for="customerid">Customer ID:</label>
<div class="col-sm-9">
<input type="number" class="form-control" id="customerid" name="customerid" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="medicationid">Medication ID:</label>
<div class="col-sm-9">
<input type="number" class="form-control" id="medicationid" name="medicationid" required />
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
<label class="control-label col-sm-3" for="doctor">Verify by Doctor ID:</label>
<div class="col-sm-9">
<input type="number" class="form-control" id="doctor" name="doctor" required />
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

?>