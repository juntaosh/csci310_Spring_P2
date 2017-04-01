<?php
function downloadFile($path, $url){
	#save the desired pdf into local tmp place
	file_put_contents($path, fopen($url, 'r'));
}

function getPDFLinkFromHTML($html){
	# Create a DOM parser object
	$dom = new DOMDocument();

	# Parse the HTML from the given doi.
	# The @ before the method call suppresses any warnings that
	# loadHTML might throw because of invalid HTML in the page.
	@$dom->loadHTML($html);
	$address= "";
	# Iterate over all the <a> tags
	foreach($dom->getElementsByTagName('a') as $link) {
	    # Show the <a href>
		$name = $link->getAttribute('name');
		if($name ==	"FullTextPDF"){
	 		$address = $link->getAttribute('href');
	   	}
		return $address;
	}
}
?>