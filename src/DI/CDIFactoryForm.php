<?php

namespace Anax\DI;

class CDIFactoryForm extends CDIFactoryDefault
{


    public function __construct()
    {
        parent::__construct();
        $this->set('form', '\Anax\HTMLForm\CForm');
    }


}