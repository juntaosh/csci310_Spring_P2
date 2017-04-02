<?php
	require 'author.php';
	require 'vendor/autoload.php';
	require 'pdfReader.php';
	require 'frequencySort.php';
	// Get word from client side javascript
	$word = $_POST['word'];
	//echo "called";
	//$tmp = new Author($word);
	//$tmp->getACMResponse();
	//$doiToLoc = $tmp->getACMPDF();
	
	$doiToLoc = array("1111"=>"./tmp/test0.pdf");
	$doiToText = array();
	foreach($doiToLoc as $key => $value){
		$str = readPDF($value);
		array_push($doiToText, [$key=>$str]);
	}
	$var = getList($doiToText[0]["1111"]);
	//echo $var[0]["word"];
	//echo ":";
	//echo $var[0]["count"];
	echo json_encode($var);
	// Use Map[DOI => $path] | pdf.jar=>parse | frequencySort($text) => Map[$word => $frequency]

?>
