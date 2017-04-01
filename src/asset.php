<?php
function downloadFile($path, $url){
	#save the desired pdf into local tmp place
	file_put_contents($path, fopen($url, 'r'));
}

function getPDFLinkFromHTML($url){
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$html = curl_exec($ch);
	curl_close($ch);

	# Create a DOM parser object
	$dom = new DOMDocument();

	# Parse the HTML from the given doi.
	# The @ before the method call suppresses any warnings that
	# loadHTML might throw because of invalid HTML in the page.
	@$dom->loadHTML($html);
	$address= "";
	# Iterate over all the <a> tags
	foreach($dom->getElementsByTagName('a') as $link) {
		$name = $link->getAttribute('name');
		if($name ==	"FullTextPDF"){
	 		$address = $link->getAttribute('href');
	 		echo $address;
		   	break;
	   	}
	}
	return $address;
}
?>