<?php
	require 'author.php';
	require 'vendor/autoload.php';
	//require 'asset.php';
?>
<html>
<head>
    <title>Example</title>
</head>
<body>

<?php
	echo 'here';
	$tmp = new Author('charlie');
	$tmp->getACMResponse();
	$tmp->getACMPDF();
	//download_file('http://dl.acm.org/ft_gateway.cfm?id=971375&ftid=251850&dwn=1&CFID=918170001&CFTOKEN=99475789');
?>
</body>
</html>