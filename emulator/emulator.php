<?php 

namespace DataStream;

require dirname(__DIR__) . '/vendor/autoload.php';
require 'util.php';

if('Linux' == PHP_OS) {
  echo "☉ ". "\033[34;34mE\033[0m" . "\033[33;33mm\033[0m" . "\033[1;31mu\033[0m";
}else {
  echo "> Emu";
}

echo PHP_EOL;

if(count($argv) < 3) {
  echo 'Usage: ' . basename(__FILE__) . ' [Config file] [port]' . PHP_EOL;
  
  echo '* Config file: The JSON file containing emulation parameters' . PHP_EOL; 
  echo '* Port: Port number to bind the server' . PHP_EOL;
  
  exit;
}

$configFileName = __DIR__ . DIRECTORY_SEPARATOR . $argv[1];
$port = $argv[2];

echo '* Reading configuration file ' . basename($configFileName) . '...';

if(file_exists($configFileName)) {
  
  $configuration = json_decode(file_get_contents($configFileName), true);
  echo ' [ok]' . PHP_EOL;
  
}else {
  
  echo PHP_EOL . '[x] Could not find configuration file, exiting' . PHP_EOL;
  exit;
  
}

$requiredVars = [
  'sourceType',
];

$defaultConfig = [
  'loadOnce' => false
];

$configuration = array_merge($defaultConfig, $configuration);

$providedVars = array_keys($configuration);

$varDiff = array_diff($requiredVars, $providedVars);

if(!empty($varDiff)) {
  echo '[x] One or more required variables are not present in the configuration file' . PHP_EOL;
  echo '    Missing variable(s): ' . implode(" ", $varDiff) . PHP_EOL;
}

$dataSource = new Source($configuration['loadOnce']);

switch ($configuration['sourceType']) {
  case 'raw':
    if(!isset($configuration['data'])) {
      echo '[x] Source type is raw but data parameter was not provided' . PHP_EOL;
      exit;
    }
    
    $dataSource->setData($configuration['data']);
    break;
  
  case 'file':
    if(!isset($configuration['dataLocation'])) {
      echo '[x] Source type is "file" but dataLocation parameter was not provided' . PHP_EOL;
      exit;
    }
    
    $configuration['dataLocation'] = __DIR__ . $configuration['dataLocation'];
    
    if(!file_exists($configuration['dataLocation'])) {
      echo '[x] Could not find file '. $configuration['dataLocation'] . PHP_EOL;
      exit;
    }
    
    $dataSource->loadFromFile($configuration['dataLocation']);
    break;
  
  default:
    echo '[x] Unknown source type "'. $configuration['sourceType'] .'"' . PHP_EOL;
    exit;
    break;
}

$server = new Emulator\Server($port, $dataSource);

echo PHP_EOL . 'Listening on port ' . $port . ' press CTRL+C to exit' . PHP_EOL;

while(1) {
    if(list($peerName, $msg) = $server->receive()) {
      echo 'Got connection from ' . $peerName . PHP_EOL;
      $server->dispatch();
    }
}

echo PHP_EOL;