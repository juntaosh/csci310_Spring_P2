<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require 'asset.php';

final class assetTest extends TestCase
{
    protected function setUp(){
        parent::setUp();
    }
    
    public function test_downloadFile(){
        $url = "http://dl.acm.org/ft_gateway.cfm?id=305904&ftid=19649&dwn=1&CFID=919391119&CFTOKEN=35233599";
        downloadFile("./tmp/test0.pdf",$url);
        $boolean = fopen("./tmp/test0.pdf", 'r');
        $this->assertNotEquals($boolean, false);
    }

    
    public function test_getPDFLinkFromHTML(){
        $url = "http://dl.acm.org/citation.cfm?doid=384267.305904&preflayout=flat";
        $result = getPDFLinkFromHTML($url);
        $this->assertContains("ft_gateway.cfm?id=305904", $result['pdf']);
        $this->assertEquals("Innovation and Technology in Computer Science Education", $result['conference']);
    }


    public function test_getPDFLinkNConf(){
        $url = "http://dl.acm.org/citation.cfm?doid=384267.305904&preflayout=flat";
        $result = getPDFLinkNConf($url);
        $this->assertContains("ft_gateway.cfm?id=305904", $result['pdf']);
        $this->assertEquals("Innovation and Technology in Computer Science Education", $result['conference']);
    }
}