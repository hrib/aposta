<?php
include 'simple_html_dom.php';
//$html = file_get_html('http://www.bing.com/images/search?q=interior+design&view=detailv2&first=1&id=C37B2B8A6FF47FF19BCE3989167383092B31022B&ccid=JiNDO4LI&simid=608034208928891174&thid=OIP.M2623433b82c81a48ab1c1c440bb64f1co0&selectedindex=2');
$html = file_get_contents('http://www.bing.com/images/search?q=interior+design&view=detailv2&first=1&id=C37B2B8A6FF47FF19BCE3989167383092B31022B&ccid=JiNDO4LI&simid=608034208928891174&thid=OIP.M2623433b82c81a48ab1c1c440bb64f1co0&selectedindex=2');

//foreach($html->find('img') as $element)
//       echo $element->src . '<br>';
$str = $html;
echo $html; 
echo '<br>';

foreach($html->find('a') as $element)
       echo $element->href . '<br>'; 

?>
