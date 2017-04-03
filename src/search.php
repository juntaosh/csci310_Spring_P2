<?php
	require 'author.php';
	require 'vendor/autoload.php';
	require 'pdfReader.php';
	require 'frequencySort.php';
	// Get word from client side javascript
	$word = $_POST['word'];
	$paperNumber = $_POST['number'];
	//echo "called";
	$tmp = new Author($word,$paperNumber);
	$tmp->getACMResponse();
	$doiToLoc = $tmp->getACMPDF();
	
	//$doiToLoc = array("1111"=>"./tmp/test0.pdf");
	$doiToText = array();
	foreach($doiToLoc as $key => $value){
		$str = readPDF($value);
		$doiToText[$key] = $str;
		//array_push($doiToText, [$key=>$str]);
	}
	$interVar = array();
	$wordToDOI = array();
	foreach($doiToText as $doi => $text){
		$tempVar = getList($text);
		foreach($tempVar as $index => $freqMap){
			if (array_key_exists($freqMap['word'], $interVar)){
				$interVar[$freqMap['word']] = $interVar[$freqMap['word']]+$freqMap['count'];
				array_push($wordToDOI[$freqMap['word']],$doi);
			}
			else {
				$interVar[$freqMap['word']] = $freqMap['count'];
				$wordToDOI[$freqMap['word']] = array($doi);
			}
		}
	}

	$var = array();

	$metaData = $tmp->getMetaData();

	foreach($interVar as $word => $frequency){
		$tempMeta = array();
		foreach($wordToDOI[$word] as $index => $doi){
			foreach($metaData as $article => $meta){
				if ($meta['DOI'] == $doi){
					array_push($tempMeta,$meta);
				}
			}
		}
		array_push($var,array('word'=>$word, 'count'=> $frequency, 'articles'=> $tempMeta));
	}

	/*foreach($var as $number=>$data){
		echo $data['word'];
		echo "<br />";
		echo $data['count'];
		echo "<br />";
		echo $data['articles'][0]["Title"];
		echo "<br />";
		echo "<br />";

	}*/

	echo json_encode($var);
	// Use Map[DOI => $path] | pdf.jar=>parse | frequencySort($text) => Map[$word => $frequency]

?>
