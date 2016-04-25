<?php
session_start();  


	/*
	 * sample example code for BingSearch.php class
	 * @author Daniel Boorn info@rapiddigitalllc.com
	 * @license apache 2.0
	 * @bingapiurl https://datamarket.azure.com/dataset/bing/search#schema
	 */
 
 
	ini_set('display_errors','1');
	require('BingSearch.php');
	
	//register for key on windows azure
	$apiKey = '4xWghqIH8s****************************izeg5GYAAV0=';
	
	$bing = new BingSearch($apiKey);
	
	# Example 1: simple image search
	echo '<pre>';
	$r = $bing->querySpellingSuggestions('testse');
	var_dump($r);
 
	
	# Example 2: advanced image search
	//https://datamarket.azure.com/dataset/bing/search#schema
	//be sure to respect the data types in the values
 
	$r = $bing->queryImage(array(
		'Query'=>"'xbox'",//string
		'Adult'=>"'Moderate'",//string
		'ImageFilters'=>"'Size:Small+Aspect:Square'",//string
		'Latitude'=>47.603450,//double
		'Longitude'=>-122.329696,//double
		'Market'=>"'en-US'",//string
		'Options'=>"'EnableHighlighting'",//string
	));
	var_dump($r);



 
 ?>
