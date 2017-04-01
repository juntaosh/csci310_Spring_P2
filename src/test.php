<?php
	require 'author.php';
	require 'vendor/autoload.php';
?>
<html>
<head>
    <title>Example</title>
</head>
<body>

<?php
	$tmp = new Author('charlie');
	$tmp->getACMResponse();
	$tmp->getACMPDF();
?>
</body>
</html>