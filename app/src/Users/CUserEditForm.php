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
use Mos\HTMLForm\CFormElementTextarea;

class CUserEditForm extends \Mos\HTMLForm\CForm
{


    public function __construct($test)
    {

        $this->users = $test;
        parent::__construct();

        $this->addElement(new CFormElementTextarea('bio', [
            'value' => '',
            'rows' => '10',
            'cols' => '50',
            'label' => 'Bio',
            'required' => true,
        ]));

        $this->addElement(new CFormElementSubmit('Update', array('callback' => array($this, 'DoSubmit'))));
    }



    protected function DoSubmit(){
        $data = [
            'userProfileText' => $this->Value('bio'),
        ];

        $this->users->save($data);

        return true;
    }
}