<?php 

class ServerTest extends PHPUnit_Framework_TestCase
{
  public function testServerBind()
  {
    $source = new DataStream\Source;
    
    $source->setData("Testing");
    
    $server = new DataStream\Emulator\Server("8080", $source);
    
    $this->assertEquals(false, $server->stopped);
    
    $server->stop();
  }
  
   
  public function testServerConn()
  {
    
    $source = new DataStream\Source;
    
    $source->setData("Testing");
    
    $server = new DataStream\Emulator\Server("8080", $source);

    $server->receive();

    $conn = stream_socket_client("tcp://127.0.0.1:8080");
    
    $got = fread($conn, strlen("Testing"));
    
    fclose($conn);
    $server->stop();
    
    $this->assertEquals($got, "Testing");
  }
}