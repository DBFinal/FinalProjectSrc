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

<div class="container">
<br />
<font size="5">Here at Cloud9 Pharmacy we strive to provide the best Doctor-Pharmacist interaction.
 Not only do we allow you to find the correct prescriptions, we also offer a diverse range of functions.
 These functions range from starting a prescription, filling a prescription, or even finding a means of contact for your customers. We hope you
 enjoy what we have to offer! If you have any questions or concerns, please do not hesitate to contact us.</font><br /><br />
<font size="4"><u>Cloud9 Pharmacy</u></font><br />
<font size="4">Address: 1477 7th St N.</font><br />
<font size="4">Email: cloud9Pharmacy@gmail.com</font><br />
<font size="4">Phone: 701-365-0050</font> 
</div>

<?php

$cursor = new page_footer("Cloud 9 Pharma");
$cursor->export();

?>