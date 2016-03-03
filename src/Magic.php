<?php
namespace DataStream;

/**
* Magic
*
* Allows you to call getPropertyName and setPropertyName on a class
* even if such methods are not defined in the class
*/

abstract class Magic
{

  function __call($name, $args)
  {
    switch(substr($name, 0, 3)) {
      case 'get':
        $getOrSet = 'get';
        break;

      case 'set':
        $getOrSet = 'set';
        break;

      default:
        $getOrSet = null;
        break;
    }

    if($getOrSet) {

      $propertyName = substr($name, 3);
      $propertyName = strtolower($propertyName[0]) . substr($propertyName, 1, strlen($propertyName));


      if($getOrSet == "get") {

        return $this->$propertyName;

      }else {

        return $this->set($propertyName, $args[0]);

      }

    }else {
      throw new \BadMethodCallException("Unknown method '$name'", 1);
    }
  }
  
  public function set($key, $value)
  {
    $this->$key = $value;

    // convert to camelCase
    $funcName = 'on' . strtoupper($key[0]) . substr($key, 1) . 'Set';
    
    // Call onPropertyNameSet if it is defined
    if(method_exists($this, $funcName)) {
      $this->$key = call_user_func([$this, $funcName], $value);
    }
    
    return $this;
  }
  
  public function get($key, $fallback = null)
  {
    if(isset($this->$key)) {
      return $this->$key;
    }
    
    return $fallback;
  }
  
}