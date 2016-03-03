<?php

namespace DataStream\Configuration;

/**
* Contains functions to be executed when a property is set
*/
class Configuration extends DefaultConfiguration
{
  /**
  * Checks if the dataLocation provided is valid (i.e. files exist)
  */
  public function onDataLocationSet($dataLocation)
  {
    if(is_array($dataLocation)) {
      $dataLocation = array_map(function($path) { 
        return EMU_PATH . DIRECTORY_SEPARATOR . $path; 
      }, $dataLocation);
      
      foreach($dataLocation as $location) {        
        if(!file_exists($location)) {
          throw new \Exception('Could not find file ' . $location);
        }
      }
      
    }else {
      $dataLocation = EMU_PATH . DIRECTORY_SEPARATOR . $dataLocation;
            
      if(!file_exists($dataLocation)) {
        throw new \Exception('Could not find file ' . $dataLocation);
      }
      
    }
    
    return $dataLocation;
  }
}