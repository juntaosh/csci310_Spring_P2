<?php
	$file_handle = fopen("../tmp/progress.md", "r");// or die ('die');
	//fwrite($file_handle,"0");
	fclose($file_handle);
?>