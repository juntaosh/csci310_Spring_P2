<?php
	$file_handle = fopen("../tmp/progress.md", 'w') or die ('die');
	fwrite($file_handle,'0');
	fclose($file_handle);
?>