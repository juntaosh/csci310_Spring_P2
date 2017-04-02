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
	// infoMap1 is the map whose key is DOI and ['title', 'author']
	private $infoMap1 = array();
	// infoMap2 is the map whose key is DOI and [conference', 'download link']
	private $infoMap2 = array();
	// doi to localpath
	private $doiToLoc = array();

	function __construct($name) {
		$this->client = new Client([
		    'base_url' => ['http://api.crossref.org/'],
		    'defaults' => [
		        'query'   => ['format' => 'json']
		    ]
		]);
		$requestStr = 'http://api.crossref.org/works?filter=member:320&rows=2&query=';
		$requestStr = $requestStr . $name;
		$this->ACMresponse = $this->client->request('GET', $requestStr);
	}

	public function getACMPDF(){
		//getACMResponse();
		$index = 0;
		foreach($this->doiarray as $doi){
			# Use the Curl extension to query crossref and get back a page of results
			$url = "http://dl.acm.org/citation.cfm?doid=".$doi;
			$url = $url."&preflayout=flat";
			//$url = "https://login.libproxy2.usc.edu/login?url=http://dl.acm.org/citation.cfm?doid=".$doi;
			$pdf_and_conference = getPDFLinkFromHTML($url);
			$this->infoMap2[$doi] = $pdf_and_conference;
			$link = $pdf_and_conference["pdf"];
			$link = 'http://dl.acm.org/'.$link;
			$path = './tmp/test'.$index.'.pdf';
			$index++;
			//$infoMap2[$doi]["pdf"]
			//$this->P2T($link);
			downloadFile($path, $link);
			//echo "success";
			//echo "<br />";
			//echo $pdf_and_conference["conference"];
			//echo "<br />";
			$this->doiToLoc[$doi] = $path;

		}
		return $this->doiToLoc;
	}

	// Pdf To Text function
	public function P2T($addr){
		$text = new PDF2Text();
		$text->setFilename($addr);
		$text->decodePDF();
		return $text->output();
	}

	public function getACMResponse(){
		$data = $this->ACMresponse->getBody();
		$data = json_decode($data, true);
		$data = $data['message']['items'];
		foreach($data as $key=>$item){
			$doi = $item['DOI'];
			$var = substr($doi, 8);
			array_push($this->doiarray, $var);

			//array_push($this->infoMap1, ["title" => $] );
		}
	}
}
?>