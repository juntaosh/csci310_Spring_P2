<?php
#download File from the give url to path
function downloadFile($path, $url){ 
	#save the desired pdf into local tmp place
	file_put_contents($path, fopen($url, 'r'));
}

function getPDFLinkFromHTML($url){
	$isCited = false;
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$html = curl_exec($ch);
	curl_close($ch);
	$breakCnt = 0;

	# Create a DOM parser object
	$dom = new DOMDocument();

	# Parse the HTML from the given doi.
	# The @ before the method call suppresses any warnings that
	# loadHTML might throw because of invalid HTML in the page.
	@$dom->loadHTML($html);
	$result = array(
		"conference" => "conference unknown",
	);
	# Iterate over all the <a> tags
	foreach($dom->getElementsByTagName('a') as $link) {
		$name = $link->getAttribute('name');
		$href = $link->getAttribute('href');
		if($name ==	"FullTextPDF"){
	 		$result["pdf"] = $href;
	 		$breakCnt = $breakCnt+1;
		   	if ($breakCnt == 2){
		   		$breakCnt = 0;
		   		break;
		   	}
	   	}
	   	else if (strpos($href,'event.cfm') !== false){
	   		$result["conference"] = $link->getAttribute('title');
	   		$breakCnt = $breakCnt+1;
	   		if ($breakCnt == 2){
	   			$breakCnt = 0;
	   			break;
	   		}
	   	}
	   	else if(strpos($href,'citation.cfm?') !== false && !$isCited){
	   		$result["conferencelink"] = substr($href,13);
	   		$isCited = true;
	   	}
	}
	return $result;
}
?>