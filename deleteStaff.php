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

$sql1 = "SELECT empId AS eId,
			CONCAT(employees.firstName,' ',employees.lastName) AS emp,
			phone AS p,
			email AS e,
			address AS a,
			CONCAT(employees.city,', ',employees.state, ', ' ,employees.zipCode) as city
			FROM employees
			INNER JOIN Login ON empId = personId
            WHERE job = '0';"; //Added a join so you can only delete those with login. That way it doesn't show anyone kept for records sake.
			
$res = $mysqli->query($sql1);
	
if ($res != false)
{
	echo "<h1>Delete Employee:</h1>\r\n";
	
	if ($res->num_rows > 0)
	{
		echo "<table class=\"table\">\r\n";
		echo "<tr><th>ID:</th><th>Employee:</th><th>Phone:</th><th>Email:</th><th>Address:</th><th>City, State, Zip:</th></tr>\r\n";
		
		while ($res_set = $res->fetch_assoc())
		{
			echo "<tr><td>" . $res_set["eId"] . "</td><td>" . $res_set["emp"] . "</td><td>" . $res_set["p"] . "</td>";
			echo "<td>" . $res_set["e"] . "</td><td>" . $res_set["a"] . "</td><td>" . $res_set["city"] . "</td></tr>\r\n";
		}
		
		echo "</table>\r\n";
		
	}
	else
	{
		echo "No Employees.\r\n<br /><br />\r\n";
	}
	
	$res->free();
}

if (isset($_POST["submit"]))
{
	$sql = "SELECT empId AS eId,
			CONCAT(employees.firstName,' ',employees.lastName) AS emp,
			phone AS p,
			email AS e,
			address AS a,
			CONCAT(employees.city,', ',employees.state, ', ' ,employees.zipCode) as city
			FROM employees
			WHERE employees.empId = '" . $_POST["employeeid"] . "'";
			
	$res = $mysqli->query($sql);
	
	if ($res != false)
	{
		if ($res->num_rows > 0)
		{
			$res_set = $res->fetch_assoc();
			echo "<div class=\"well\">\r\n";
			echo "<kbd>Employee ID:</kbd> " . $res_set["eId"] . "<br />\r\n";
			echo "<kbd>Employee:</kbd> " . $res_set["emp"] . "<br />\r\n";
			echo "<kbd>Phone:</kbd> " . $res_set["p"] . "<br />\r\n";
			echo "<kbd>Email:</kbd> " . $res_set["e"] . "<br />\r\n";
			echo "<kbd>Adress:</kbd> " . $res_set["a"] . "<br />\r\n";
			echo "<kbd>City, State, Zip::</kbd> " . $res_set["city"] . "<br />\r\n";
			echo "<form method=\"POST\" action=\"" . $_SERVER["PHP_SELF"] . "\">\r\n<br />\r\n";
			echo "<button type=\"submit\" id=\"fulfill\" name=\"fulfill\" class=\"btn btn-danger\">Delete</button>\r\n";
			echo "</form>\r\n";
			echo "</div>\r\n";
			
			$_SESSION["goodbye"] = $res_set["eId"]; //Communicates with fulfill form action below.
		}
		else
		{
			result_message("problem","Employee not found!","warning");
		}
	}
	else
	{
		result_message("error","There exists an error in the SQL query!","danger");
	}
}
	
if (isset($_POST["fulfill"]) && isset($_SESSION["goodbye"]))
{
	$sql = "DELETE FROM login WHERE job = '0' AND personId = '" . $_SESSION["goodbye"] . "'";
	$res = $mysqli->query($sql);
	
	if ($res != false)
	{
		$sql = "DELETE FROM employees WHERE empId = '" . $_SESSION["goodbye"] . "'";
		$res = $mysqli->query($sql);
		
		if ($res != false)
		{
			header("Location: " . $_SERVER['REQUEST_URI']);
			result_message("success","Employee has been deleted.","success");
		}
		else
		{
			result_message("error","Could not finish delete, a prescription is probably tied to this name!","warning");
		}
	}
	else
	{
		result_message("error","Could not delete employee from login!","danger");
	}
	
	unset($_SESSION["goodbye"]);
}


$mysqli->close();

?>

<div class="well">
<form class="form-horizontal" method="POST" action="deleteStaff.php">
<div class="form-group">
<label class="control-label col-sm-3" for="employeeid">Employee ID:</label>
<div class="col-sm-9">
<input type="number" class="form-control" id="employeeid" name="employeeid" required />
</div>
</div>
<div class="form-group">
<label class="control-label col-sm-3" for="submit">&nbsp;</label>
<div class="col-sm-9">
<button type="submit" id="submit" name="submit" class="btn btn-danger">Delete</button>
</div>
</div>
</form>
</div>

<?php
echo "</div>\r\n";	
$cursor = new page_footer("Cloud9 Pharmacy");
$cursor->export();
?>