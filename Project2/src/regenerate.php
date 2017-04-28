<?php
	require "pdfReader.php";
	require "frequencySort.php";

	$chosen = $_POST['files'];
	function getWordList($chosen){
		$chosen = substr($chosen, 0, strlen($chosen)-1);
		$files = explode("|", $chosen);
		$interVar = array();
		$word2Article = array();
			
		foreach($files as $index => $file){
			$text = readPDF($file);
			$frequencylist = getList($text);
			foreach($frequencylist as $index => $freqMap){
				if (array_key_exists($freqMap['word'], $interVar)){
					$interVar[$freqMap['word']] = $interVar[$freqMap['word']]+$freqMap['count'];
					$word2Article[$freqMap['word']] = $word2Article[$freqMap['word']]."|".$file;
				}
				else {
					$interVar[$freqMap['word']] = $freqMap['count'];
					$word2Article[$freqMap['word']] = $file;
				}
			}
		}
		$return = array();
		foreach($interVar as $word => $count){
			array_push($return, array("word" => $word, "count" => $count, "articles" => $word2Article[$word]));
		}

		return $return;	
	}

	$return = getWordList($chosen);
	echo json_encode($return);
?>