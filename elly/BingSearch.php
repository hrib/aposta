<?php
session_start();

 $Key = "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA"; // this is my api key
 $request ='https://api.datamarket.azure.com/Bing/Search/v1/Image?Query=%27flamengo%27&Adult=%27Moderate%27';
 $response = file_get_contents($request);
 $jsonobj = json_decode($response);
 echo('<ul ID="resultList">');
 foreach($jsonobj->SearchResponse->Image->Results as $value){
  echo('<li class="resultlistitem"><a href="' . $value->Url . '">');
  echo('<img src="' . $value->Thumbnail->Url. '" width="150" height="150"></li>'); 
 }
 echo("</ul>");

?>
