<?php
	require 'searchObj.php';
	require './vendor/autoload.php';
	require 'pdfReader.php';
	require 'frequencySort.php';

	// Get word from client side javascript
	$word = $_POST['word'];
	$paperNumber = $_POST['number'];
	$isAuthor = $_POST['filter'];
	$file_handle = fopen("../tmp/progress.md", "w");
	fwrite($file_handle,"0");
	fclose($file_handle);

	$tempArr = array();

	$file_handle = fopen("../tmp/history.md", "r");
	$tempArr = json_decode(fgets($file_handle));
	fclose($file_handle);

	$insert = true;
	foreach ($tempArr as $index => $words){
		if ($words == $word){
			$insert = false;
			break;
		}
	}
	if ($insert){
		array_push($tempArr,$word);
	}

	if (count($tempArr) > 5){
		array_splice($tempArr,0,1);
	}

	$file_handle = fopen("../tmp/history.md", "w");
	fwrite($file_handle,json_encode($tempArr));
	fclose($file_handle);

	$tmp = new SearchObj($word,$paperNumber,$isAuthor);
	$tmp->getDatabaseResponse();
	$doiToLoc = $tmp->getPDF();
	
	$doiToText = array();
	foreach($doiToLoc as $key => $value){
		$str = readPDF($value);
		$doiToText[$key] = $str;
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
		$file_handle = fopen("../tmp/progress.md", "r");
		$line = fgets($file_handle);
		fclose($file_handle);
		$line = $line+0.2;

		$file_handle = fopen("../tmp/progress.md", "w");
		fwrite($file_handle,$line);
		fclose($file_handle);
	
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

	echo json_encode($var);

?>
