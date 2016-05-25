<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-05-17
 * Time: 13:36
 */

namespace Anax\DI;


class CDIFactory extends CDIFactoryDefault
{

    public function __construct()
    {
        parent::__construct();

        $this->set('usersTest', '\Anax\Users\User');



        $this->setShared('usersTestTwo', function(){
            $model = new \Anax\Users\User();
            $model->setDI($this);
            return $model;

        });


    }

}