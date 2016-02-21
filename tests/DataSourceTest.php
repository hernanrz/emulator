<?php 

 /**
  * DataSource test
  */
 class DataSourceTest extends PHPUnit_Framework_Testcase
 {
   public function testRawSource()
   {
     $source = new DataStream\Source;
     
     $source->setData("hello this is a test");
     
     $this->assertEquals("hello this is a test", $source->getData());
   }
   
   public function testFileSource()
   {
     $source = new DataStream\Source;
     
     $source->loadFromFile(__DIR__ . '/testfile.txt');
     
     $this->assertEquals(file_get_contents(__DIR__ . '/testfile.txt'), $source->getData());
   }
 }
 