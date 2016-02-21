<?php 

namespace DataStream\Emulator;

/**
 * Simple TCP server
 */
class Server
{
  
  private $resource;
  
  private $dataSource;
  
  private $currentClient = null;
  
  public $stopped = true;
  
  function __construct($port, \DataStream\Source $dataSource, $host = '127.0.0.1')
  {
    $localSocket = 'tcp://' . $host . ':' . $port;
    
    $this->dataSource = $dataSource;
    
    $this->resource = stream_socket_server($localSocket);
    
    $this->stopped = false;
  }
  
  public function receive()
  {
    $this->currentClient = stream_socket_accept($this->resource, -1, $peerName);
    $msg = fread($this->currentClient, 1024); //Read whatever the client sends before returning, prevents connection reset errors
    return [$peerName, $msg];
  }
  
  public function dispatch()
  {
    if (null == $this->currentClient) {
      return false;
    }
    
    fwrite($this->currentClient, $this->getResponseData());
    fclose($this->currentClient);
    
    return true;
  }
  
  public function stop()
  {
    return $this->stopped = stream_socket_shutdown($this->resource, STREAM_SHUT_RDWR);
  }
  
  public function getResponseData()
  {
    return $this->dataSource->getData();
  }
}
