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
<h1>About us:</h1>
&nbsp;&nbsp;&nbsp;&nbsp;Here at Cloud9 Pharmacy we strive to provide the best Doctor-Pharmacist interaction.
Not only do we allow you to find the correct prescriptions, we also offer a diverse range of functions.
These functions range from starting a prescription, filling a prescription, or even finding a means of contact for your customers. We hope you
enjoy what we have to offer! If you have any questions or concerns, please do not hesitate to contact us.<br /><br />
<kbd>Cloud9 Pharmacy</kbd>
<ul>
<li>Address: 1477 7th St N, Fargo, ND 58103</li>
<li>Email: cloud9pharmacy@gmail.com</li>
<li>Phone: (701) 365-0050</li>
</ul>
</div>

<?php

$cursor = new page_footer("Cloud 9 Pharma");
$cursor->export();

?>