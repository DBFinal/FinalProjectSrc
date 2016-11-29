<?php

require("common_funcs.php");

$cursor = new page_header("Cloud9 Pharma");
$cursor->add_stylesheet("style_index.css");
$cursor->add_stylesheet("https://fonts.googleapis.com/css?family=Poiret+One");
$cursor->export();

$cursor = new jumbotron("img/cloud9.png");
$cursor->export();

standard_nav();

?>

<div class="blue-basin container-fluid text-center">
<h1><span class="glyphicon glyphicon-plus blue"></span> Welcome to Cloud 9 Pharmacy! <span class="glyphicon glyphicon-plus blue"></span></h1>
</div>

<?php

$cursor = new page_footer("Cloud 9 Pharma");
$cursor->export();

?>