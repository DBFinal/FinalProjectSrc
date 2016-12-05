<?php

require("common_funcs.php");

$cursor = new page_header("Cloud9 Pharmacy");
$cursor->add_stylesheet("style_index.css");
$cursor->add_stylesheet("https://fonts.googleapis.com/css?family=Poiret+One");
$cursor->export();

$cursor = new jumbotron("img/cloud9.png");
$cursor->export();

standard_nav();

//Keeps the setting in drop-down menu between pages.
function select($num)
{
	$not_selected = true;
	
	if (isset($_GET["job"]))
	{
		if ($num == intval($_GET["job"]))
		{
			echo "value=\"" . $num . "\" selected";
			$not_selected = false;
		}
	}
	
	if ($not_selected)
	{
		echo "value=\"" . $num . "\"";
	}
}

function form_field($type, $name, $label, $length)
{
	$lenstr = "";
	if ($length != -1) {$lenstr = " maxlength=\"" . $length . "\"";}
	echo "<div class=\"form-group\">\r\n";
	echo "<label class=\"control-label col-sm-3\" for=\"" . $name . "\">" . $label . "</label>\r\n";
	echo "<div class=\"col-sm-9\">\r\n";
	echo "<input type=\"" . $type . "\" class=\"form-control\" id=\"" . $name . "\" name=\"" . $name . "\"" . $lenstr . " required />\r\n";
	echo "</div>\r\n</div>\r\n";
}

echo "<div class=\"container\">\r\n";
echo "<h1>Create User</h1>\r\n";

if (isset($_GET["job"]))
{
	$job = intval($_GET["job"]);
	
	echo "<div class=\"well\">\r\n";
	echo "<form class=\"form-horizontal\" method=\"POST\" action=\"" . $_SERVER["PHP_SELF"] . "\">\r\n";
	
	if ($job != 2)
	{
		form_field("text","firstname","First Name:",-1);
		form_field("text","lastname","Last Name:",-1);
		
		if ($job == 0)
		{
			form_field("number","phone","Phone:",10);
			form_field("email","email","Email:",-1);
			form_field("text","address","Address:",-1);
			form_field("text","city","City:",-1);
			form_field("text","state","State:",2);
			form_field("number","zip","Zip:",5);
		}
		else
		{
			form_field("number","license","License Number:",9);
			form_field("text","clinic","Clinic:",-1);
		}
	}
	
	form_field("text","username","Username:",-1);
	form_field("password","password","Password:",-1);
	form_field("password","confirm","Confirm Password:",-1);
	
	echo "<div class=\"form-group\">\r\n";
	echo "<label class=\"control-label col-sm-3\" for=\"create\">&nbsp;</label>\r\n";
	echo "<div class=\"col-sm-9\">\r\n";
	echo "<button type=\"submit\" id=\"create\" name=\"create\" class=\"btn btn-info\">Create</button>\r\n";
	echo "</div>\r\n</div>\r\n";
	echo "</form>\r\n";
	echo "</div>\r\n";
	
	$_SESSION["job"] = $job;
}

if (isset($_POST["create"]))
{
	$mysqli = new mysqli($db_ip,$db_user,$db_pass,$db_base);
	if ($mysqli->connect_errno) {exit("Cannot connect to MySQL!");}

	$job = $_SESSION["job"];
	$pid = -1;
	$sql = "INSERT INTO ";
	$pw_mismatch = false;

	if ($_POST["password"] != $_POST["confirm"])
	{
		$pw_mismatch = true;
	}
	
	if ($job != 2 && $pw_mismatch == false) //Admins don't have to insert into a second table so skip.
	{
		if ($job == 0) //We are a pharmacist.
		{
			$sql .= "employees VALUES (NULL,'" . $_POST["firstname"] . "','"
				. $_POST["lastname"] . "','"
				. $_POST["phone"] . "','"
				. $_POST["email"] . "','"
				. $_POST["address"] . "','"
				. $_POST["city"] . "','"
				. $_POST["state"] . "','"
				. $_POST["zip"] . "')";
				
			$res = $mysqli->query($sql);
			
			if ($res != false)
			{
				$pid = $mysqli->insert_id;
			}
		}
		else //We're a doctor.
		{
			$sql .= "doctors VALUES (NULL,'" . $_POST["firstname"] . "','"
				. $_POST["lastname"] . "','"
				. $_POST["license"] . "','"
				. $_POST["clinic"] . "')";
				
			$res = $mysqli->query($sql);
			
			if ($res != false)
			{
				$pid = $mysqli->insert_id;
			}
		}
	}

	if ($pid != -1 || $job == 2 || $pw_mismatch) //Either have no errors or be admin.
	{
		if ($pw_mismatch == false)
		{
			$user = strtolower(htmlspecialchars($_POST["username"]));
			$pass = password_hash($_POST["password"], PASSWORD_DEFAULT);
			
			$sql = "INSERT INTO Login VALUES (NULL, '" . $user . "', '" . $pass . "', '" . $job . "', '" . $pid . "')";
			$res = $mysqli->query($sql);
			
			if ($res == false)
			{
				result_message("error","User could not be created because of second query!","danger");
			}
			else
			{
				result_message("success","User successfully created!","info");
			}
		}
		else
		{
			result_message("problem","Password mismatch!","danger");
		}
	}
	else
	{
		result_message("error","User could not be created because of first query!","danger");
	}
	
	$mysqli->close();
	unset($_SESSION["job"]);
}

?>

<div class="well">
<form class="form-horizontal" method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
<div class="form-group">
<label class="control-label col-sm-3" for="job">Job:</label>
<div class="col-sm-9">
<select class="form-control" name="job" id="job">
<option <?php select(0); ?>>Pharmacist</option>
<option <?php select(1); ?>>Doctor</option>
<option <?php select(2); ?>>Admin</option>
</select>
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="set">&nbsp;</label>
<div class="col-sm-9">
<button type="submit" id="set" class="btn btn-primary">Set</button>
</div>
</div>
</form>
</div>

<?php

echo "</div>\r\n";

$cursor = new page_footer("Cloud9 Pharmacy");
$cursor->export();

?>