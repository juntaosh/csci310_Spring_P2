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

	function __construct($name,$paperNumber) {
		$this->client = new Client([
		    'base_url' => ['http://api.crossref.org/'],
		    'defaults' => [
		        'query'   => ['format' => 'json']
		    ]
		]);
		$requestStr = 'http://api.crossref.org/works?filter=member:320&rows=';
		$requestStr = $requestStr . $paperNumber;
		$requestStr = $requestStr . '&query=';
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
			$pdf_and_conference = getPDFLinkFromHTML($url);
			$this->infoMap2[$doi] = $pdf_and_conference;
			$link = $pdf_and_conference["pdf"];
			$link = 'http://dl.acm.org/'.$link;
			$path = '../tmp/test'.$index.'.pdf';
			$index++;
			downloadFile($path, $link);
			$this->doiToLoc[$doi] = $path;
			$file_handle = fopen("../tmp/progress.md", "r");
			$line = fgets($file_handle);
			fclose($file_handle);
			$line = $line+0.7;

			$file_handle = fopen("../tmp/progress.md", "w");
			fwrite($file_handle,$line);
			fclose($file_handle);

		}
		return $this->doiToLoc;
	}

	public function getMetaData(){
		$metaData = array();
		foreach($this->doiarray as $article=>$doi){
			$metaData[$article] = array(
				"DOI"=>$doi,
				"Title"=> $this->infoMap1[$doi]['title'],
				"Author"=>$this->infoMap1[$doi]['author'],
				"Conference"=>$this->infoMap2[$doi]['conference'],
				"Link"=>$this->doiToLoc[$doi]
			);
		}
		return $metaData;
	}

	public function getACMResponse(){
		$data = $this->ACMresponse->getBody();
		$data = json_decode($data, true);
		$data = $data['message']['items'];
		foreach($data as $key=>$item){
			$doi = $item['DOI'];
			$var = substr($doi, 8);
			array_push($this->doiarray, $var);
			$author = $item['author'];
			$title = $item['title'];
			$authorNames = $author[0]['given'] . " ";
			$authorNames = $authorNames . $author[0]['family'];
			
			if (count($author)>1){
				foreach ($author as $number => $name){
					if ($number !== 0){
						$authorNames = $authorNames . ", ";
						$authorNames = $author[$number]['given'] . " ";
						$authorNames = $authorNames . $author[$number]['family'];
					}
				}
			}
			$this->infoMap1[$var] = array('title'=>$title[0],'author'=>$authorNames);
			$file_handle = fopen("../tmp/progress.md", "r");
			$line = fgets($file_handle);
			fclose($file_handle);
			$line = $line+0.1;

			$file_handle = fopen("../tmp/progress.md", "w");
			fwrite($file_handle,$line);
			fclose($file_handle);
		}
	}

	public function getInfoMap1(){return $this->infoMap1;}
	public function getInfoMap2(){return $this->infoMap2;}
	public function getInfoMap3(){return $this->infoMap3;}
}
?>