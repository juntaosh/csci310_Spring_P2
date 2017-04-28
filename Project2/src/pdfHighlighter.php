<?php
	$pdfName = $_POST['path'];
	$keyword = $_POST['word'];
    //function PDFHighlighter($pdfName, $keyword){
    exec("java -jar pdfHighlighter.jar " . $pdfName. ' '. $keyword);
    //}
    echo json_encode($pdfName);
	//PDFHighlighter($pdfName, $keyword);
?>