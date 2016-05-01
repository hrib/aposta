<?php
include 'simple_html_dom.php';
$html = file_get_html('http://www.bing.com/images/search?q=interior+design&view=detailv2');

//foreach($html->find('img') as $element)
//       echo $element->src . '<br>';
$str = $html;
echo $html; 
echo '<br>';

foreach($html->find('a') as $element)
       echo $element->href . '<br>'; 

?>
