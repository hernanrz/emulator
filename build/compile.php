<?php 
/**
* Packages everything into a nice PHAR archive
*/

if(file_exists('emulator.phar')) {
  unlink('emulator.phar');
}

$phar = new Phar('emulator.phar', 0, 'emulator.phar');

$phar->buildFromDirectory(dirname(__DIR__));
$phar->delete('composer.phar');
$phar->setDefaultStub('emulator/emulator.php');