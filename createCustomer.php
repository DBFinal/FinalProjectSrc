<?php

require("common_funcs.php");

$cursor = new page_header("Cloud9 Pharmacy");
$cursor->add_stylesheet("style_index.css");
$cursor->add_stylesheet("https://fonts.googleapis.com/css?family=Poiret+One");
$cursor->export();

$cursor = new jumbotron("img/cloud9.png");
$cursor->export();

standard_nav();

echo "<div class=\"container\">\r\n";
echo "<h1>New Patient:</h1>\r\n";

if (isset($_POST["submit"]))
{
	$mysqli = new mysqli($db_ip,$db_user,$db_pass,$db_base);
	if ($mysqli->connect_errno) {exit("Cannot connect to MySQL!");}

	$sql = "INSERT INTO Customers VALUES (NULL, '"
		. $_POST["firstname"] . "','"
		. $_POST["lastname"] . "','"
		. $_POST["phone"] . "','"
		. $_POST["email"] . "','"
		. $_POST["address"] . "','"
		. $_POST["city"] . "','"
		. $_POST["state"] . "','"
		. $_POST["zip"] . "')";
		
	$res = $mysqli->query($sql);
	
	if ($res == false)
	{
		result_message("error","Could not add patient, check query!","danger");
	}
	else
	{
		result_message("success","Patient successfully added!","info");
	}
	
	$mysqli->close();
}

?>

<div class="well">
<form class="form-horizontal" method="POST" action="createCustomer.php">
<div class="form-group">
<label class="control-label col-sm-3" for="firstname">First Name:</label>
<div class="col-sm-9">
<input type="text" class="form-control" id="firstname" name="firstname" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="lastname">Last Name:</label>
<div class="col-sm-9">
<input type="text" class="form-control" id="lastname" name="lastname" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="phone">Phone:</label>
<div class="col-sm-9">
<input type="number" class="form-control" id="phone" name="phone" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="email">Email:</label>
<div class="col-sm-9">
<input type="email" class="form-control" id="email" name="email" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="address">Address:</label>
<div class="col-sm-9">
<input type="text" class="form-control" id="address" name="address" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="city">City:</label>
<div class="col-sm-9">
<input type="text" class="form-control" id="city" name="city" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="state">State:</label>
<div class="col-sm-9">
<input type="text" class="form-control" id="state" name="state" maxlength="2" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="zip">Zip:</label>
<div class="col-sm-9">
<input type="number" class="form-control" id="zip" name="zip" maxlength="5" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="submit">&nbsp;</label>
<div class="col-sm-9">
<button type="submit" id="submit" name="submit" class="btn btn-primary">Add</button>
</div>
</div>
</form>
</div>

<?php

echo "</div>\r\n";

$cursor = new page_footer("Cloud9 Pharmacy");
$cursor->export();

?>