<?php
require("asset.php");
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Subscriber\Cache\CacheSubscriber;
use GuzzleHttp\Subscriber\Cache\CacheStorage;
use GuzzleHttp\Subscriber\Cache\DefaultCacheStorage;
use Doctrine\Common\Cache\FilesystemCache;
error_reporting(E_ALL);


class Author {
	private $client;
	public $AMCresponse;
	public $IEEEresponse;
	public $urlarray = array();
	function __construct($name) {
		$this->client = new Client([
		    'base_url' => ['http://api.crossref.org/'],
		    'defaults' => [
		        'query'   => ['format' => 'json']
		    ]
		]);
		$requestStr = 'http://api.crossref.org/works?filter=member:320&query=';
		$requestStr = $requestStr . $name;
		$this->ACMresponse = $this->client->request('GET', $requestStr);
	}

	public function getACMPDF(){
		$index = 0;
		echo $index;
		echo "<br />";
		foreach($this->urlarray as $url){
			echo $url;
			# Use the Curl extension to query crossref and get back a page of results
			$ch = curl_init();
			$timeout = 5;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$html = curl_exec($ch);
			curl_close($ch);

			$link = getPDFLinkFromHTML($html);
			$link = 'http://dl.acm.org/'.$link;
			$path = './tmp/acm.'.$index.'.pdf';
			echo $path;
			$index++;
			downloadFile($path, $link);
		}
	}

	public function getACMResponse(){
		$data = $this->ACMresponse->getBody();
		$data = json_decode($data, true);
		$data = $data['message']['items'];
		foreach($data as $key=>$item){
			$var = $item['URL'];
			echo $item['URL'];
			array_push($this->urlarray, $var);
		}
	}
}
?>