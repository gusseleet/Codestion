<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-04-28
 * Time: 12:09
 */

namespace gel\Escape;


use Mos\HTMLForm\CForm;
use Mos\HTMLForm\CFormElementSubmit;
use Mos\HTMLForm\CFormElementText;

class EscapeController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    public function initialize(){

        $this->escape = new \gel\Escape\CEscape();
        $this->escape->setDI($this->di);
    }


    public function viewAction(){


        $source = new \Mos\Source\CSource([
            'secure_dir' => '../..',
            'base_dir' => '../../Anax-MVC/app/view/escape/',
            'add_ignore' => ['.htaccess'],
        ]);



        $this->views->add('escape/main', [
            'e' => $this->escape,
            'content' => $source->View()
        ]);

    }


}