<?php
	//$url = $_POST['link'];
	//$url = "http://dl.acm.org/citation.cfm?id=".$url."&preflayout=flat";
	function getConferenceList($url){
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
		
		$result = array();
		$skip = 4;
		$index = 0;
		
		# Iterate over all the <a> tags which contains citation.cfm?
		foreach($dom->getElementsByTagName("a") as $link) {
			$href = $link->getAttribute("href");
			if(strpos($href, "citation.cfm?") !== false){
				if($skip != 0){
					$skip--;
				} else {
					//echo $index.": ";
					//echo $link->textContent;
					//echo "<br />";
					$result[$index] = $link->textContent;
					$index++;
				}
			}
		}
		return $result;
	}
	//$result = getConferenceList($url);
	//print_r($result);
	//echo json_encode($result);
?>