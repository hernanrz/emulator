<?php 

namespace DataStream\Configuration;

/**
 *  Configuration loader
 */
class Loader
{
    private $requiredOptions = [
      'sourceType',
    ];
  
    private $missingOptions = [];
    
    /**
    * @var string The directory in which every file is located
    */
    private $directory;
    
    function __construct($directory = null)
    {
      $this->directory = (null == $directory) ? __DIR__ : $directory;
    }
    
    /**
    * Loads a JSON file with settings
    *
    * @return Configuration object
    */
    public function loadFromFile($filePath)
    {
      if(!file_exists($filePath)) {
        throw new \Exception("Error: configuration file $filePath does not exist");
      }
      
      $configuration = json_decode(file_get_contents($filePath), true);
      
      if(null === $configuration) {
        throw new \Exception("Error loading configuration file, more info: " . json_last_error_msg());
      }
      
      return $this->loadFromArray($configuration);
    }
    
    /**
    * @return Configuration object
    */
    public function loadFromArray(array $configOptions)
    {
      $configuration = new Configuration($this->directory);
      
      foreach($configOptions as $key => $val) {
        $configuration->set($key, $val);
      }
      
      if(!$this->checkRequiredOptions($configuration)) {
        throw new \Exception("One or more required options are not present in the configuration provided: ". implode(', ', $this->missingOptions));
      }
      
      return $configuration;
    }
    
    /**
    * Check if required options are present in configuration object
    * @return boolean true if all required options are present, false otherwise
    */
    private function checkRequiredOptions(Configuration $configuration)
    {
      
      $missing = false;
      
      foreach($this->requiredOptions as $optName) {
        if(null === $configuration->get($optName))  {
          $this->missingOptions[] = $optName;
          $missing = true;
        }
      }
      
      return !$missing;
    }
}