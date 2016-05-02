<?php
include 'simple_html_dom.php';
$html = file_get_html('http://www.bing.com/images/search?q=interior+design&view=detailv2&first=1&selectedindex=0&id=21E2D43D44635A4E9D0FAFE011BC90EB39B17CA');

//foreach($html->find('img') as $element)
//       echo $element->src . '<br>';
$str = $html;
echo $html; 
echo '<br>';

foreach($html->find('a') as $element)
       echo $element->href . '<br>'; 

?>
