<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require '../src/searchObj.php';
require '../src/vendor/autoload.php';
//require 'asset.php';

final class authorTest extends TestCase
{
    protected function setUp(){
        parent::setUp();
        $word = ["Republican leaders in the Capitol meanwhile","have largely distanced themselves from the accusations as they attempt to focus on their own internal rifts that have hobbled the effort to repeal and replace Obamacare But Trumps accusations only added to a swirl of questions about Russia meddling in the 2016 elections already being investigated by House and Senate lawmakers"];
    }
    //add one more key word search next time
	/**
	 * @covers Author::__construct
	 */
    public function testCanGenerateAuthor(){
    	$author = new Author("charlie", 2);
    	$data = $author->ACMresponse->getBody();
    	$data = $data.'message'.'items';
    	$this->assertContains("charlie", $data);
    }

    /**
	 * @covers Author::__construct
     * @covers Author::getACMResponse
     * @covers Author::getInfoMap1
     */
    
    public function testCanCorrectResultOfAuthorName(){
    	$author = new Author("charlie", 2);
    	$author->getACMResponse();
    	foreach($author->getInfoMap1() as $DOI => $arr){
   			$this->assertContains("Charlie", $arr['author']);	
   			break;	
    	}
    }


    
	/**
	* @covers Author::__construct
    * @covers Author::getACMResponse
    * @covers Author::getACMPDF
    * @covers Author::getMetaData
    * @covers Author::getInfoMap1
    **/
    public function testCanDownloadDesiredPDF_getCorrectInfo(){
    	$author = new Author("charlie", 2);
    	$author->getACMResponse();
    	$doiToLoc = $author->getACMPDF();
    	foreach($doiToLoc as $DOI => $Loc){
    		$this->assertFileExists($Loc);
    	}
    	$metaData = $author->getMetaData();
    	$this->assertContains("Charlie", $metaData[0]['Author']);
    	$this->assertContains("RoboProf", $metaData[0]['Title']);
    	$this->assertContains("Computer", $metaData[0]['Conference']);
    }
}
?>