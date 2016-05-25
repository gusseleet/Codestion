<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-05-24
 * Time: 01:57
 */

namespace gel\Popup;


class CPopup implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    private $message = [];


    public function __construct()
    {
        $this->message = (isset($_SESSION['message']) && $_SESSION['message'] != '') ? $_SESSION['message'] : null;
        unset($_SESSION['message']);
    }

    public function setMessage($thisMessage, $url = "HTTP_REFERER")
    {
        $_SESSION['message'][] = $thisMessage;
        $this->redirect();

    }

    public function redirect(){

        $url = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
        $url = $this->url->create($url);
        $this->response->redirect($url);
    }




    public function getMessage()
    {
        if ($this->message) {
        $html = "<div id='popup2' style='display: none; width: 400px; height: 200px; overflow: auto'>";

        $html .= "<div rel='title'>";
        $html .=  $this->message[0]['title'];
        $html .= "</div>";
        $html .= "<div rel='body'>";
        $html .=   "<div style='padding: 10; font-size: 11px; line-height: 150%;'>";
        $html .=  $this->message[0]['msg'];
        $html .=  "</div>";
        $html .=  "</div>";
        $html .=  "</div>";


            echo $html;
        }
    }
}