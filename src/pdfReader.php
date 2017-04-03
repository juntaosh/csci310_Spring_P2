<?php
    function readPDF($pdfName){
        exec("java -jar pdfReader.jar " . $pdfName, $output);
        
        $realOutput = "";
        for($i= 0; $i < count($output); $i++){
            $realOutput = $realOutput." ";
            $realOutput = $realOutput.$output[$i];
       }
    
        return $realOutput;
    }
?>