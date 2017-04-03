<?php
	require 'pdfReader.php';

	$word = $_POST['word'];
	$path = $_POST['path'];

	$text = readPDF($path);
	$text = strtolower($text);
	$word = $word;
	$result = substr_count($text,$word.' ');
	$result = $result + substr_count($text,$word.'.');
	$result = $result + substr_count($text,$word.';');
	$result = $result + substr_count($text,$word.',');
	$result = $result + substr_count($text,$word.'!');
	$result = $result + substr_count($text,$word.'?');
	$result = $result + substr_count($text,$word.'(');
	$result = $result + substr_count($text,$word.')');
	$result = $result + substr_count($text,$word.'[');
	$result = $result + substr_count($text,$word.']');
	$result = $result + substr_count($text,$word.'-');
	$result = $result + substr_count($text,$word.'\'');

	echo json_encode($result);
?>