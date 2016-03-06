<?php 

use DataStream\Configuration\Loader;

class ConfigurationLoaderTest extends PHPUnit_Framework_Testcase
{
  public function testLoadFromArray()
  {
    $loader = new Loader();
  
    $conf = $loader->loadFromArray([
      'sourceType' => 'type',
      'loadOnce'   => true,
    ]);
    
    
    $this->assertEquals($conf->getSourceType(), 'type');
    $this->assertEquals($conf->get('loadOnce'), true);
  }
  

  /**
  * @expectedException Exception
  */
  public function testRequiredOptions()
  {
    $loader = new Loader();

    $loader->loadFromArray([]);
  }
  
  public function testLoadFromFile()
  {
    $loader = new Loader(dirname(__DIR__));
    
    $loader->loadFromFile(__DIR__ . "/testing.json");
  }
} 