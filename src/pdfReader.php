<?php
    function readPDF($pdfName){
        echo $pdfName;
        exec("java -jar pdfReader.jar " . $pdfName, $output);
        return $output;
    }
    
    /*
    // test codes for testing reading outputs
    $realOutput = readPDF("test.pdf");
    for($i= 0; $i < count($realOutput); $i++){
		echo $realOutput[$i];
		echo "\r\n";
	}
    */
?>