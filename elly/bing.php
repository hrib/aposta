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
	$apiKey = '4bsI4zHy6e5Tr1IcXdYobAQ4gCujDVZ2fi0nXO7sdRk';
	
	//$bing = new BingSearch($apiKey);
	
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


	function queryImage($query){
		return $this->query('Image',$query);
	}



	function query($type,$query){
		if(!is_array($query)) $query = array('Query'=>"'{$query}'");
		try{
			print_r(getJSON("{$this->apiRoot}{$type}",$query));
			exit;
			return getJSON("{$this->apiRoot}{$type}",$query);
		}catch(Exception $e){
			die("<pre>{$e}</pre>");
		}
	}
	
	/*
	 * get json via curl with basic auth
	 * @param string $url
	 * @param array $data
	 * @return object
	 * @throws exception on non-json response (api error)
	 */
	function getJSON($url,$data){
		if(!is_array($data)) throw new Exception("Query Data Not Valid. Type Array Required");
		$data['$format'] = 'json';
		$url .= '?' . http_build_query($data);
		
		$ch = curl_init($url);
	
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	        curl_setopt($ch, CURLOPT_USERPWD,  $this->apiKey . ":" . $this->apiKey);
	        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	        $r = curl_exec($ch);
	        $json = json_decode($r);
	        if($json==null) throw new Exception("Bad Response: {$r}\n\n{$url}");
	        return $json;
	}



 
 ?>
