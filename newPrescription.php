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
<style> 

label.customer-labels{
	margin: 8px 5px;
	
}
td.labels{

width:20px;}
th.customer-Header{
	font-size:27px;
	width:50px;
}

img{
	float:right;
}


</style>
<form>
<table>
<tr>
<th class="customer-Header"><u>Prescription</u></th>
</tr>
<tr>
<td class="labels">
<label for="fname" class="customer-labels">Customer ID:</label></td><td >
  <input  type="number" id="fname" name="fname" required> 
</td>
</tr>
<tr>
<td class="labels">
<label for="medId" class="customer-labels">Medication ID:</label></td><td>
  <input  type="number" id="medId" name="medId" required> 
</td>
</tr>
<tr>
<td class="labels">
<label for="pCount" class="customer-labels">Pill Count:</label></td><td>
  <input  type="number" id="pCount" name="pCount" required> 
</td>
</tr>
<tr>
<td class="labels">
<label for="refill" class="customer-labels">How many refills?</label></td><td>
  <input  type="number" id="refill" name="refill" required> 
</td>
</tr>
<tr>
<td class="labels">
<label for="instruct" class="customer-labels">Instructions</label></td><td>
  <input  type="text" id="instruct" name="instruct" required pattern="[a-zA-Z0-9\s]+"> 
</td>
</tr>
<tr>
<td class="labels">
<label for="doctor" class="customer-labels">Verify by Doctor ID:</label></td><td>
  <input  type="number" id="doctor" name="doctor" required> 
</td>
</tr>
 </table>
 <input type="submit">
<img src=" http://www.clipartkid.com/images/313/pill-bottle-clipart-cliparts-co-ER73Sa-clipart.png" alt="PILLS" style="width:112px;height:112px;">
</form>
<!-- Need to add new page or success message then do logic for adding to database next. -->


<?php
$cursor = new page_footer("Cloud 9 Pharma");
$cursor->export();

?>