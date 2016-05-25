<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-04-21
 * Time: 15:23
 */

namespace gel\Comment;


use Mos\HTMLForm\CFormElementSubmit;
use Mos\HTMLForm\CFormElementTextarea;

class CAnswerForm extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;



    public function __construct($commentID = null, $userID = null, $answers)
    {
        parent::__construct();
        $this->commentID = $commentID;
        $this->userID = $userID;
        $this->answers = $answers;


        $this->addElement(new CFormElementTextarea('commentArea', [
            'value' => '',
            'rows' => '10',
            'cols' => '50',
            'label' => 'Type your comment',
            'required' => true,
        ]));

        $this->addElement(new CFormElementSubmit('Create', array('callback' => array($this, 'DoSubmit'), 'class' => 'btn btn-md btn-primary')));

    }


    protected function DoSubmit(){


        if(!$this->answers->usersTest11->isUserActive())
            $this->errorOutput->setMessage(['msg' => 'What are you doing... Trying to break the system?', 'title' => 'You need to be logged in']);

        else {

            $data = [
                'commentID' => $this->commentID,
                'userID' =>  $this->userID,
                'body' =>  $this->Value('commentArea'),
            ];

            $this->answers->save($data);
        }
        return true;

    }


}