<?php
require("asset.php");
include('class.pdf2text.php');
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
	public $doiarray = array();
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
		/*$requestStr = 'http://api.crossref.org/works?filter=member:263&query=';
		$requestStr = $requestStr . $name;
		$this->ACMresponse = $this->client->request('GET', $requestStr);*/
	}

	public function getACMPDF(){
		//getACMResponse();
		$index = 0;
		foreach($this->doiarray as $doi){
			# Use the Curl extension to query crossref and get back a page of results
			$url = "http://dl.acm.org/citation.cfm?doid=".$doi;
			$link = getPDFLinkFromHTML($url);
			$link = 'http://dl.acm.org/'.$link;
			$path = './tmp/test'.$index.'.pdf';
			$index++;
			//$this->P2T($link);
			downloadFile($path, $link);
		}
	}


	public function P2T($addr){
		$text = new PDF2Text();
		$text->setFilename($addr);
		$text->decodePDF();
		echo $text->output();
	}

	public function getACMResponse(){
		$data = $this->ACMresponse->getBody();
		$data = json_decode($data, true);
		$data = $data['message']['items'];
		foreach($data as $key=>$item){
			$doi = $item['DOI'];
			$var = substr($doi, 8);
			array_push($this->doiarray, $var);
		}
	}
}
?>