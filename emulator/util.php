<?php
/**
* Output something to the console
*/
function out($msg)
{
  echo $msg . PHP_EOL;
}

/**
* Display an error in the console
*/
function error($msg)
{
  return out('[x] ' . $msg);
}