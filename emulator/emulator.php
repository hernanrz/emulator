<?php 

namespace DataStream;

use DataStream\Configuration\Loader;

require dirname(__DIR__) . '/vendor/autoload.php';
require 'util.php';

define('VERBOSE', true);
define('EMU_PATH', dirname(__DIR__));

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

echo '* Reading configuration file ' . basename($configFileName) . '...' . PHP_EOL;

$confLoader = new Loader();

try {
    $configuration = $confLoader->loadFromFile($configFileName);
} catch (\Exception $e) {
    error($e->getMessage());
    exit;
}

$dataSource = new Source($configuration->getLoadOnce());

switch ($configuration->getSourceType()) {
  case 'raw':
    if(!$configuration->getData()) {
      echo '[x] Source type is raw but data parameter was not provided' . PHP_EOL;
      exit;
    }
    
    $dataSource->setData($configuration->getData());
    break;
  
  case 'file':
    if(!$configuration->getDataLocation()) {
      echo '[x] Source type is "file" but dataLocation parameter was not provided' . PHP_EOL;
      exit;
    }

    if(is_array($configuration->getDataLocation())) {
      $dataSource->loadFromFiles($configuration->getDataLocation());
    }else {
      $dataSource->loadFromFile($configuration->getDataLocation());
    }
    
    break;
  
  default:
    echo '[x] Unknown source type "'. $configuration->getSourceType() .'"' . PHP_EOL;
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