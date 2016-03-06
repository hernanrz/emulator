<?php

namespace DataStream\Configuration;

/**
* Contains functions to be executed when a property is set
*/
class Configuration extends DefaultConfiguration
{
  
  /**
  * @var string The directory in which every file is located
  */
  private $directory;
  
  function __construct($directory)
  {
    $this->directory = $directory . DIRECTORY_SEPARATOR;
  }
  
  /**
  * Checks if the dataLocation provided is valid (i.e. files exist)
  */
  public function onDataLocationSet($dataLocation)
  {
    if(is_array($dataLocation)) {
      $dataLocation = array_map(function($path) { 
        return $this->directory . $path; 
      }, $dataLocation);
      
      foreach($dataLocation as $location) {        
        if(!file_exists($location)) {
          throw new \Exception('Could not find file ' . $location);
        }
      }
      
    }else {
      $dataLocation = $this->directory . $dataLocation;
            
      if(!file_exists($dataLocation)) {
        throw new \Exception('Could not find file ' . $dataLocation);
      }
      
    }
    
    return $dataLocation;
  }
}