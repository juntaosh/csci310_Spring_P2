<?php
	$file_handle = fopen("../tmp/progress.md", "r");
	$line = fgets($file_handle);
	echo json_encode($line);
	fclose($file_handle);
?>