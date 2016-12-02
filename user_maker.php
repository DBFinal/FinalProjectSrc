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
echo "<h1>Create User</h1>\r\n";

if (isset($_POST["username"]) && isset($_POST["password"]))
{
	$mysqli = new mysqli($db_ip,$db_user,$db_pass,$db_base);
	if ($mysqli->connect_errno) {exit("Cannot connect to MySQL!");}
	
	$user = strtolower(htmlspecialchars($_POST["username"]));
	$pass = password_hash($_POST["password"], PASSWORD_DEFAULT);
	$job = $_POST["job"];
	$pid = $_POST["pid"];
	
	$sql = "INSERT INTO Login VALUES (NULL, '" . $user . "', '" . $pass . "', '" . $job . "', '" . $pid . "')";
	$res = $mysqli->query($sql);
	
	if ($res == false)
	{
		result_message("error","User could not be created!","danger");
	}
	else
	{
		result_message("success","User successfully created!","info");
	}
	
	$mysqli->close();
}

?>

<div class="well">
<form class="form-horizontal" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
<div class="form-group">
<label class="control-label col-sm-3" for="username">Username:</label>
<div class="col-sm-9">
<input type="text" class="form-control" id="username" name="username" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="password">Password:</label>
<div class="col-sm-9">
<input type="password" class="form-control" id="password" name="password" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="job">Job:</label>
<div class="col-sm-9">
<select class="form-control" name="job" id="job">
<option value="0">Pharmacist</option>
<option value="1">Doctor</option>
<option value="2">Admin</option>
</select>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="pid">Personal ID:</label>
<div class="col-sm-9">
<input type="number" class="form-control" id="pid" name="pid" value="-1" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="submit">&nbsp;</label>
<div class="col-sm-9">
<button type="submit" id="submit" name="submit" class="btn btn-primary">Create User</button>
</div>
</div>
</form>
</div>

<?php

echo "</div>\r\n";

$cursor = new page_footer("Cloud 9 Pharma");
$cursor->export();

?>