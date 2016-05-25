<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-04-28
 * Time: 12:28
 */

namespace gel\Escape;


use Mos\HTMLForm\CFormElementSubmit;
use Mos\HTMLForm\CFormElementText;
use Mos\HTMLForm\CFormElementTextarea;

class EscapeForm extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;


    public function __construct($a){

        parent::__construct();
        $this->controller = $a;
        $this->addElement(new CFormElementText('Input'));



        $this->addElement(new CFormElementSubmit('Submit', ['callback' => [$this, 'DoSubmit']]));
    }


    protected function doSubmit(){

        $this->saveInSession  = true;
        return true;
    }

}