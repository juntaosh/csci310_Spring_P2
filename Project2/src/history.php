<?php
	$file_handle = fopen("../tmp/history.md", "r");
	$line = fgets($file_handle);
	echo $line;
	fclose($file_handle);
?>