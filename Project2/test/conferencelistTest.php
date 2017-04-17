<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require 'conferencelistForTest.php';
require '../src/vendor/autoload.php';
//require 'asset.php';

final class conferencelistTest extends TestCase
{
    protected function setUp(){
        parent::setUp();
        $url = "http://dl.acm.org/citation.cfm?id=1940941.1940974&preflayout=flat";
    }
    /**
	* getConferenceList
	*
    */
    public function testgetConferenceList(){
    	$result = getConferenceList("http://dl.acm.org/citation.cfm?id=1940941.1940974&preflayout=flat");
    	$this->assertGreaterThan(0,count($result));
    }
}

?>