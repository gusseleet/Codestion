<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-04-20
 * Time: 17:41
 */

namespace Anax\Users;


use Mos\HTMLForm\CFormElementPassword;
use Mos\HTMLForm\CFormElementSubmit;
use Mos\HTMLForm\CFormElementText;

class CUserForm extends \Mos\HTMLForm\CForm
{

    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    public function __construct($test)
    {

        $this->users = $test;
        parent::__construct();

        $this->addElement(new CFormElementText('username', array('value' =>'')))
            ->addElement(new CFormElementText('email', array('value' => '')))
            ->addElement(new CFormElementPassword('password'))
            ->addElement(new CFormElementSubmit('Create', array('callback' => array($this, 'DoSubmit'))));




        $this->setValidation('username', array('not_empty'))
            ->SetValidation('email', array('not_empty', 'email_adress'))
            ->setValidation('password', array('not_empty'));


    }



    protected function DoSubmit(){
        $now = gmdate('Y-m-d H:i:s');
        $gravatar = new CGravatar();
        $data = [
            'email' => $this->Value('email'),
            'username' => $this->Value('username'),
            'password' => password_hash($this->Value('password'), PASSWORD_DEFAULT),
            'created' => $now,
            'active' => $now,
            'gravatar' => $gravatar->get_gravatar($this->Value('email')),
            'userProfileText' => "Change me...."
        ];



                $this->users->save($data);

        return true;
    }
}