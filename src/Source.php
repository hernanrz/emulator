<?php 

namespace DataStream;

/**
 * Data source loader
 */
class Source
{
  
  protected $data = null;
  
  public function loadFromFile($filePath)
  {
    $this->data = file_get_contents($filePath);
  }

  public function getData()
  {
    return $this->data;
  }
  
  public function setData($data) 
  {
    $this->data = $data;
    
    return $this;
  }
}