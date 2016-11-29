<html>
<head>
<title>User Creator</title>
</head>
<body>

<?php

require("common_funcs.php");

$doctor = 0;

if (isset($_POST["user"]) && isset($_POST["pass"]))
{
	$mysqli = new mysqli($db_ip,$db_user,$db_pass,$db_base);
	if ($mysqli->connect_errno) {exit("Cannot connect to MySQL!");}
	
	if (isset($_POST["doc"]))
	{
		$doctor = 1;
	}
	
	$user = strtolower(htmlspecialchars($_POST["user"]));
	$pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);
	
	$sql = "insert into login values (NULL, '" . $user . "', '" . $pass . "', '" . $doctor . "');";
	$res = $mysqli->query($sql);
	
	if ($res == false)
	{
		echo "ERROR, could not create user!<br />";
	}
	else
	{
		echo "User successfully created!<br />";
	}
	
	$mysqli->close();
}

?>

<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
<table>
<tr><td>Name:</td><td><input type="text" name="user" /></td></tr>
<tr><td>Pass:</td><td><input type="password" name="pass" /></td></tr>
<tr><td>Is doctor?</td><td><input type="checkbox" name="doc" /></td></tr>
<tr><td></td><td><input type="submit" /></td></tr>
</table>
</form>

</body>
</html>
