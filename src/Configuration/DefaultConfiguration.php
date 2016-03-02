<?php

namespace DataStream\Configuration;

use DataStream\Magic;

/**
* Default configuration
*
* Every property of this class should be protected
* Magic class takes care of basic getters and setters
*/
class DefaultConfiguration extends Magic
{
    protected $loadOnce = false;
    
    protected $data = null;
    
    protected $dataLocation = '';
}