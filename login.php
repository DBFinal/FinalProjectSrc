<?php

require("common_funcs.php");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  Login Class
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class login implements exportable
{
	private $error_msg = "";
	
	function __construct($c_error)
	{
		$this->error_msg = $c_error;
	}
	
	private function ex_form_field($name, $type, $length)
	{
		$out = "<div class=\"form-group\">\r\n<div class=\"row\">\r\n<div class=\"col-sm-4\">\r\n";
		$out .= "<label for=\"" . $name . "\">" . ucfirst($name) . ":</label>\r\n";
		$out .= "<input type=\"" . $type . "\" class=\"form-control\" name=\"" . $name . "\" ";
		$out .= "maxlength=\"" . $length . "\" placeholder=\"Enter " . $name . "\">\r\n";
		$out .= "</div>\r\n</div>\r\n</div>\r\n";
		return $out;
	}
	
	function export()
	{
		$error_report = "";
		
		if ($this->error_msg != "")
		{
			$error_report = "<div class=\"alert alert-danger\"><strong>Error!</strong> " . $this->error_msg . "</div>\r\n";
		}
		
		$out = "<!--Login Form-->\r\n";
		$out .= "<div class=\"container\">\r\n";
		$out .= $error_report;
		$out .= "<form method=\"POST\" action=\"/c9/finalprojectsrc/login.php\">\r\n";
		$out .= $this->ex_form_field("user","text",128);
		$out .= $this->ex_form_field("password","password",128);
		$out .= "<button type=\"submit\" class=\"btn btn-default\">Submit</button>\r\n";
		$out .= "</form>\r\n</div>\r\n\r\n";
		echo $out;
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  Page Definition
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

initialize_session_vars();

$mysqli = new mysqli($db_ip,$db_user,$db_pass,$db_base);
if ($mysqli->connect_errno) {exit("Cannot connect to MySQL!");}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION["loggedin"] == false)
{
	sleep(2); //Deters brute forcers.
	
	$username = strtolower(fixinput($_POST["user"]));
	$password = $_POST["password"];
	
	$sql = "SELECT id, password, doctor FROM login WHERE username = '" . $username . "';";
	$res = $mysqli->query($sql);
	
	if ($res != false && $res->num_rows > 0)
	{
		$res_set = $res->fetch_assoc();
		
		if (password_verify($password,$res_set["password"]))
		{
			$_SESSION["loggedin"] = true;
			$_SESSION["loguser"] = $username;
			$_SESSION["logid"] = $res_set["id"];
			$_SESSION["logisdoctor"] = $res_set["doctor"];
			$_SESSION["logispharmacist"] = !$res_set["doctor"]; //If were not a doctor, then we are a pharmacist.
		}
		else
		{
			$_SESSION["loggedin"] = false;
			$error = "Incorrect username or password!";
		}
    }
	else
	{
		$error = "Incorrect username or password!";
	}
	
	$res->free();
}

if (isset($_GET["e"]))
{
	$e = intval(fixinput($_GET["e"]));
	
	switch($e)
	{
		case 0:
			$error = "Insufficient privileges to access that item!";
			break;
		default:
			$error = " ";
			break;
	}
}

if ($_SESSION["loggedin"])
{
	header("Location:/c9/finalprojectsrc/index.php");
}

$cursor = new page_header("Cloud9 Pharma");
$cursor->add_stylesheet("style_index.css");
$cursor->add_stylesheet("https://fonts.googleapis.com/css?family=Poiret+One");
$cursor->export();

$cursor = new jumbotron("img/cloud9.png");
$cursor->export();

standard_nav();
standard_title("Login");

$cursor = new login($error);
$cursor->export();

$cursor = new page_footer("Cloud9 Pharma");
$cursor->export();

$mysqli->close();

?>