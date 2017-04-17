<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require '../src/searchObj.php';
require '../src/vendor/autoload.php';
//require 'asset.php';

final class searchObjTest extends TestCase
{
    protected function setUp(){
        parent::setUp();
        $word = ["Republican leaders in the Capitol meanwhile","have largely distanced themselves from the accusations as they attempt to focus on their own internal rifts that have hobbled the effort to repeal and replace Obamacare But Trumps accusations only added to a swirl of questions about Russia meddling in the 2016 elections already being investigated by House and Senate lawmakers"];
    }
    //add one more key word search next time
	/**
	 * @covers SearchObj::__construct
     * @covers SearchObj::getInfoMap1
	 */
    public function testCanGenerateSearchAuthor(){
    	$searchObj = new SearchObj("charlie", 2, true);
    	$searchObj->getDatabaseResponse();
        $data1 = $searchObj->getInfoMap1();
    	$this->assertNotEmpty($data1);
    }

    /**
     * @covers SearchObj::__construct
     */
    public function testCanGenerateSearchKeyWord(){
        $searchObj = new SearchObj("render", 2, false);
        $searchObj->getDatabaseResponse();
        $data = $searchObj->getInfoMap1();
        $this->assertNotEmpty($data);
    }

    /**
	 * @covers SearchObj::__construct
     * @covers SearchObj::getDatabaseResponse
     * @covers SearchObj::getInfoMap1
     */    
    public function testCanCorrectResultOfSearchObjName(){
    	$searchObj = new SearchObj("charlie", 2, true);
    	$searchObj->getDatabaseResponse();
    	foreach($searchObj->getInfoMap1() as $DOI => $arr){
   			$this->assertContains("Charlie", $arr['author']);	
   			break;
    	}
    }

	/**
	* @covers SearchObj::__construct
    * @covers SearchObj::getDatabaseResponse
    * @covers SearchObj::getPDF
    * @covers SearchObj::getMetaData
    * @covers SearchObj::getInfoMap1
    * @covers SearchObj::getInfoMap2
    **/
    public function testCanDownloadDesiredPDF_getCorrectInfo(){
    	$searchObj = new SearchObj("charlie", 2, true);
    	$searchObj->getDatabaseResponse();
    	$doiToLoc = $searchObj->getPDF();
        $data2 = $searchObj->getInfoMap2();
        $this->assertNotEmpty($data2);
    	foreach($doiToLoc as $DOI => $Loc){
    		$this->assertFileExists($Loc);
    	}
    	$metaData = $searchObj->getMetaData();
    	$this->assertContains("Charlie", $metaData[0]['Author']);
    	$this->assertContains("public", $metaData[0]['Title']);
    	$this->assertContains("Computer", $metaData[0]['Conference']);
    }
}