<?php

require("common_funcs.php");

$cursor = new page_header("Cloud9 Pharma");
$cursor->add_stylesheet("style_index.css");
$cursor->add_stylesheet("https://fonts.googleapis.com/css?family=Poiret+One");
$cursor->export();

$cursor = new jumbotron("img/cloud9.png");
$cursor->export();

standard_nav();

$prescription_results = "";

echo "<div class=\"container\">\r\n";
echo "<h1>Prescription</h1>\r\n";

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
			//$out = "";
			//$out .= $res_set["
		}
	}
	else
	{
		//SQL error.
	}
	
	$mysqli->close();
}

?>

<div class="well">
<form class="form-horizontal" method="POST" action="fulfillResults.php">
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