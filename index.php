<?php

require("common_funcs.php");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//  Carousel Class
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class carousel implements exportable
{
	private $name = "";
	private $slide_count = 0;
	private $item_img = array();
	private $item_title = array();
	private $item_sub = array();
	
	function __construct($c_name)
	{
		$this->name = $c_name;
	}
	
	private function ex_indicators($num)
	{
		$out = "";
		$out .= "<ol class=\"carousel-indicators\">\r\n";
		
		for ($i = 0; $i < $num; $i++)
		{
			$active_str = "";
			if ($i == 0) {$active_str = " class=\"active\"";}
			$out .= "<li data-target=\"#" . $this->name . "\" data-slide-to=\"" . $i . "\"" . $active_str . "></li>\r\n";
		}
		
		$out .= "</ol>\r\n";
		
		return $out;
	}
	
	private function ex_item($index, $active)
	{
		$out = "";
		$active_str = "";
		if ($active) {$active_str = " active";}
		$out .= "<div class=\"item" . $active_str . "\">\r\n";
		$out .= "<img src=\"" . $this->item_img[$index] . "\" alt=\"Image\" />\r\n";
		$out .= "<div class=\"carousel-caption\">\r\n";
		$out .= "<h2><kbd>" . $this->item_title[$index] . "</kbd></h2>\r\n";
		$out .= "<h4><kbd>" . $this->item_sub[$index] . "</kbd></h4>\r\n";
		$out .= "</div>\r\n</div>\r\n";
		return $out;
	}
	
	private function ex_controls()
	{
		$out = "";
		$out .= "<a class=\"left carousel-control\" href=\"#" . $this->name . "\" role=\"button\" data-slide=\"prev\">\r\n";
		$out .= "<span class=\"glyphicon glyphicon-chevron-left\" aria-hidden=\"true\"></span>\r\n";
		$out .= "<span class=\"sr-only\">Previous</span>\r\n</a>\r\n";
		$out .= "<a class=\"right carousel-control\" href=\"#" . $this->name . "\" role=\"button\" data-slide=\"next\">\r\n";
		$out .= "<span class=\"glyphicon glyphicon-chevron-right\" aria-hidden=\"true\"></span>";
		$out .= "<span class=\"sr-only\">Next</span>\r\n</a>\r\n";
		return $out;
	}
	
	function add_item($img, $title, $subtitle)
	{
		$this->slide_count++;
		array_push($this->item_img,$img);
		array_push($this->item_title,$title);
		array_push($this->item_sub,$subtitle);
		return $this->slide_count - 1;
	}
	
	function export()
	{
		$out = "<!--Carousel: " . $this->name . "-->\r\n";
		$out .= "<div id=\"" . $this->name . "\" class=\"carousel slide\" data-ride=\"carousel\">\r\n";
		$out .= $this->ex_indicators($this->slide_count);
		$out .= "<div class=\"carousel-inner\" role=\"listbox\">\r\n";
		
		for ($i = 0; $i < $this->slide_count; $i++)
		{
			$active = false;
			if ($i == 0) {$active = true;}
			$out .= $this->ex_item($i,$active);
		}
		
		$out .= $this->ex_controls();
		$out .= "</div>\r\n</div>\r\n\r\n";
		
		echo $out;
	}
}

$cursor = new page_header("Cloud9 Pharmacy");
$cursor->add_stylesheet("style_index.css");
$cursor->add_stylesheet("https://fonts.googleapis.com/css?family=Poiret+One");
$cursor->export();

$cursor = new jumbotron("img/cloud9.png");
$cursor->export();

standard_nav();

?>

<div class="blue-basin container-fluid text-center">
<h1><span class="glyphicon glyphicon-plus blue"></span> Welcome to Cloud9 Pharmacy! <span class="glyphicon glyphicon-plus blue"></span></h1>
</div>

<?php

$motto = "Get medicated with Cloud9 Pharmacy!";
$cursor = new carousel("main_caro");

$cursor->add_item("img/carousel/image1.jpg","You better hope that water is clean!",$motto);
$cursor->add_item("img/carousel/image2.jpg","Did you eat some bad shrooms?",$motto);
$cursor->add_item("img/carousel/image3.jpg","Don't let these critters leave germs on your food!",$motto);
$cursor->add_item("img/carousel/image4.jpg","You won't believe how much money we steal from you!",$motto);

$cursor->export();

$cursor = new page_footer("Cloud9 Pharmacy");
$cursor->export();

?>