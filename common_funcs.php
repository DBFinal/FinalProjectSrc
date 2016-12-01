<?php

session_start();

interface exportable
{
	function export();
}

$db_ip = "localhost";
$db_user = "root";
$db_pass = "changeme";
$db_base = "cloud9";

function fixinput($data)
{
	$dubdash = "--";
	$data = str_replace($dubdash,"-",$data);
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data,ENT_QUOTES);
	return $data;
}

function standard_nav()
{
	$cursor = new navigation("mainNav");
	$cursor->add_item("Home","/c9/finalprojectsrc/index.php","home");
	$cursor->add_item("Doctors","/c9/finalprojectsrc/doctors.php","heart");
	$cursor->add_item("Pharmacists","/c9/finalprojectsrc/pharmacists.php","cloud");
	$cursor->add_item("About Us","/c9/finalprojectsrc/aboutUs.php","info-sign");

	if (!isset($_SESSION["loggedin"]))
	{
		$_SESSION["loggedin"] = false;
	}
	
	if ($_SESSION["loggedin"])
	{
		$rside = $cursor->add_item($_SESSION["loguser"],"","user");
		$cursor->set_right_side($rside);
	}
	else
	{
		$rside = $cursor->add_item("Login","/c9/finalprojectsrc/login.php","log-in");
		$cursor->set_right_side($rside);
	}

	$cursor->set_active_on_href($_SERVER["PHP_SELF"]);
	$cursor->export();
}

function standard_title($title)
{
	echo "<!--Title-->\r\n<div class=\"container text-center\">\r\n<h1>" . $title . "</h1>\r\n</div>\r\n\r\n";
}

function initialize_session_vars()
{
	if (!isset($_SESSION["loggedin"]))
	{
		$_SESSION["loggedin"] = false;
	}
}

function get_user_name()
{
	$user = "anonymous";
	
	if (isset($_SESSION["loguser"]))
	{
		$user = $_SESSION["loguser"];
	}
	
	return $user;
}

function get_user_id()
{
	$id = -1;
	
	if (isset($_SESSION["logid"]))
	{
		$id = intval($_SESSION["logid"]);
	}
	
	return $id;
}

function get_person_id()
{
	$id = -1;
	
	if (isset($_SESSION["logperosnid"]))
	{
		$id = intval($_SESSION["logpersonid"]);
	}
	
	return $id;
}

function doctor_privilege()
{
	$doctor = false;
	
	if (isset($_SESSION["logisdoctor"]))
	{
		if ($_SESSION["logisdoctor"] == 1)
		{
			$doctor = true;
		}
	}
	
	return $doctor;
}

function pharmacist_privilege()
{
	$pharmacist = false;
	
	if (isset($_SESSION["logispharmacist"]))
	{
		if ($_SESSION["logispharmacist"] == 1)
		{
			$pharmacist = true;
		}
	}
	
	return $pharmacist;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  Page Header Class
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class page_header implements exportable
{
	private $title = "";
	private $css_count = 0;
	private $stylesheets = array();
	
	function __construct($c_title)
	{
		$this->title = $c_title;
	}
	
	function add_stylesheet($sheet)
	{
		$this->css_count++;
		array_push($this->stylesheets,$sheet);
		return $this->css_count - 1;
	}

	function export()
	{
		$out = "";
		$out .= "<!DOCTYPE html>\r\n<html lang=\"en\">\r\n<head>\r\n";
		$out .= "<title>" . $this->title . "</title>\r\n";
		$out .= "<meta charset=\"utf-8\" />\r\n";
		$out .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\" />\r\n";
		$out .= "<link rel=\"stylesheet\" href=\"http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" />\r\n";
		
		for ($i = 0; $i < $this->css_count; $i++)
		{
			$out .= "<link rel=\"stylesheet\" href=\"" . $this->stylesheets[$i] . "\" />\r\n";
		}
		
		$out .= "<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js\"></script>\r\n";
		$out .= "<script src=\"http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>\r\n";
		$out .= "</head>\r\n<body>\r\n\r\n";
		
		echo $out;
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  Navigtion Class
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class navigation implements exportable
{
	private $name = "";
	private $link_active = -1;
	private $link_count = 0;
	private $link_text = array();
	private $link_href = array();
	private $link_icon = array();
	private $link_right_side = array(); //Links that show up on the right side are true.
	
	function __construct($c_name)
	{
		$this->name = $c_name;
	}
	
	private function ex_hamburger()
	{
		$out = "";
		$out .= "<div class=\"navbar-header\">\r\n";
		$out .= "<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#" . $this->name . "\">\r\n";
		for ($i = 0; $i < 3; $i++) {$out .= "<span class=\"icon-bar\"></span>\r\n";}
		$out .= "</button>\r\n</div>\r\n";
		return $out;
	}
	
	private function ex_linkitem($item)
	{
		$style_class = "nav-glyph-color ";
		$list_class = "";
		if ($this->link_active == $item) {$style_class = ""; $list_class=" class=\"active\"";}
		$out = "<li" . $list_class . "><a href=\"" . $this->link_href[$item] . "\">";
		$out .= "<span class=\"glyphicon " . $style_class . "glyphicon-" . $this->link_icon[$item] . "\">";
		$out .= "</span> " . $this->link_text[$item] . "</a></li>\r\n";
		return $out;
	}
	
	private function ex_navbar()
	{
		$out = "";
		$out .= "<div class=\"collapse navbar-collapse\" id=\"" . $this->name . "\">\r\n";
		$out .= "<ul class=\"nav navbar-nav\">\r\n";
		
		for ($i = 0; $i < $this->link_count; $i++)
		{
			if ($this->link_right_side[$i] == false)
			{
				$out .= $this->ex_linkitem($i);
			}
		}
		
		$out .= "</ul>\r\n<ul class=\"nav navbar-nav navbar-right\">\r\n";
		
		for ($i = 0; $i < $this->link_count; $i++)
		{
			if ($this->link_right_side[$i] == true) 
			{
				$out .= $this->ex_linkitem($i);
			}
		}
		
		$out .= "</ul>\r\n</div>\r\n";
		
		return $out;
	}
	
	function add_item($text,$href,$icon)
	{
		$this->link_count++;
		array_push($this->link_text,$text);
		array_push($this->link_href,$href);
		array_push($this->link_icon,$icon);
		array_push($this->link_right_side,false);
		return $this->link_count - 1;
	}
	
	function set_active($item)
	{
		$this->link_active = $item;
	}
	
	function set_active_on_href($link)
	{
		for ($i = 0; $i < $this->link_count; $i++)
		{
			if ($this->link_href[$i] == $link)
			{
				$this->set_active($i);
				break;
			}
		}
	}
	
	function set_right_side($item)
	{
		$this->link_right_side[$item] = true;
	}
	
	function export()
	{
		$out = "<!--Navigation: " . $this->name . "-->\r\n";
		$out .= "<nav class=\"navbar navbar-inverse\">\r\n<div class=\"container-fluid\">\r\n";
		$out .= $this->ex_hamburger();
		$out .= $this->ex_navbar();
		$out .= "</div>\r\n</nav>\r\n\r\n";
		
		echo $out;
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  Jumbotron Class
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class jumbotron implements exportable
{
	private $logo = "";
	
	function __construct($c_logo_img)
	{
		$this->logo = $c_logo_img;
	}
	
	function export()
	{
		$out = "<!--Jumbotron-->\r\n";
		$out .= "<div class=\"jumbotron\">\r\n";
		$out .= "<div class=\"container text-center\">\r\n";
		$out .= "<img src=\"" . $this->logo . "\" class=\"img-responsive\" />\r\n";
		$out .= "</div>\r\n</div>\r\n\r\n";
		
		echo $out;
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  Jumbotron Class
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class drop_down_menu implements exportable
{
	private $name = "";
	private $item_count = 0;
	private $item_text = array();
	private $item_value = array();
	
	function __construct($c_name)
	{
		$this->name = $c_name;
	}
	
	function add_item($text,$value)
	{
		$this->item_count++;
		array_push($this->item_text,$text);
		array_push($this->item_value,$value);
		return $this->item_count - 1;
	}
	
	function export()
	{
		$out = "<!--Drop-Down Menu-->\r\n";
		$out .= "<select class=\"form-control\" id=\"" . $name . "\">\r\n";
		
		for ($i = 0; $i < $this->item_count; $i++)
		{
			$out .= "<option value=\"" . $this->item_value[$i] . "\">" . $this->item_text[$i] . "</option>\r\n";
		}
		
		$out .= "</select>\r\n";
		echo $out;
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  Page Footer Class
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class page_footer implements exportable
{
	private $paragraph = "";
	
	function __construct($c_para)
	{
		$this->paragraph = $c_para;
	}
	
	function export()
	{
		$out = "<!--Footer-->\r\n";
		$out .= "<footer class=\"container-fluid text-center\">\r\n";
		$out .= $this->paragraph . "\r\n";
		$out .= "</footer>\r\n</body>\r\n</html>\r\n";
		echo $out;
	}
}

?>