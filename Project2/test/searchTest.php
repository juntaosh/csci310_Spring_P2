<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require 'search.php';

final class searchTest extends TestCase
{
    protected function setUp(){
        parent::setUp();
        $word = "charlie";
        $_POST['word'] = $word;
        $number = 2;
        $_POST['number'] = $number;
        
    }
    
    public function testCanGetCorrectWordMap(){
        $_POST['word'] = "charlie";
        $_POST['number'] = 2;
    }
}