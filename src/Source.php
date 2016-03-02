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
  public $filePath = null;
  
  /**
  * @var array Array of file paths to be read and concatenated
  */
  public $filePaths = null;
  
  function __construct($loadOnce = true)
  {
    $this->loadOnce = $loadOnce;
  }
  
  public function loadFromFile($filePath)
  {
    $this->filePath = $filePath;
    $this->data = file_get_contents($filePath);
  }
  
  public function loadFromFiles(array $filePaths)
  {
    
    $this->data = '';
    $this->filePaths = $filePaths;
    
    foreach ($filePaths as $filePath) {
      $this->data .= file_get_contents($filePath);
    }
  }

  public function getData()
  {
    if (!$this->loadOnce && $this->filePath) {
      $this->loadFromFile($this->filePath);
    }elseif (!$this->loadOnce && is_array($this->filePaths)) {
      $this->loadFromFiles($this->filePaths);
    }
    
    return $this->data;
  }
  
  public function setData($data) 
  {
    $this->data = $data;
    
    return $this;
  }
}