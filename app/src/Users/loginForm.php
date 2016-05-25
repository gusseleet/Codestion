<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-05-11
 * Time: 15:33
 */

namespace Anax\Users;

use Mos\HTMLForm\CFormElementPassword;
use Mos\HTMLForm\CFormElementSubmit;
use Mos\HTMLForm\CFormElementText;

class loginForm extends \Mos\HTMLForm\CForm

{

    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    public function __construct($users)
    {
        $this->users = $users;

        parent::__construct();

        $this->addElement(new CFormElementText('Username', array('value' => null, 'class' => 'form-control')))
            ->addElement(new CFormElementPassword('Password', array('value' => null, 'class' => 'form-control')))
            ->addElement(new CFormElementSubmit('Login', array('callback' => function () {
        $this->users->userLogin([
                'username' => $this->Value('Username'),
                'password' => $this->Value('Password'),
            ]
        );
    },'class' => 'btn btn-md btn-primary')));


        $this->check();

    }

}