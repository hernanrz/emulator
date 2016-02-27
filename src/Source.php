<?php 

namespace DataStream;

/**
 * Data source loader
 */
class Source
{
  
  protected $data = null;
  
  /**
  * @var boolean Whether the file should be read once or every time getData is called
  */
  public $loadOnce;
  
  /**
  * @var string Path to the last file loaded
  */
  public $filePath;
  
  function __construct($loadOnce = true)
  {
    $this->loadOnce = $loadOnce;
  }
  
  public function loadFromFile($filePath)
  {
    $this->filePath = $filePath;
    $this->data = file_get_contents($filePath);
  }

  public function getData()
  {
    if (!$this->loadOnce) {
      $this->loadFromFile($this->filePath);
    }
    
    return $this->data;
  }
  
  public function setData($data) 
  {
    $this->data = $data;
    
    return $this;
  }
}