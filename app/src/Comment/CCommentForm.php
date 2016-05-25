<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-04-21
 * Time: 15:23
 */

namespace gel\Comment;


use Mos\HTMLForm\CFormElementSubmit;
use Mos\HTMLForm\CFormElementText;
use Mos\HTMLForm\CFormElementTextarea;

class CCommentForm extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;



    public function __construct($aComment = null, $comments = null, $userID = null, $qId = null, $username = null)
    {
        parent::__construct();
        $this->comment = $aComment;
        $this->comments = $comments;
        $this->userID = $userID;
        $this->qID = $qId;
        $this->username = $username;


        $this->addElement(new CFormElementTextarea('commentArea', [
            'value' => is_null($aComment) ? '' :$this->comment->comment,
            'rows' => '10',
            'cols' => '50',
            'label' => 'Type your comment',
            'required' => true,
            'class' => 'form-control',
        ]));

        $this->addElement(new CFormElementSubmit('Create', array('callback' => array($this, 'DoSubmit'), 'class' => 'btn btn-md btn-primary')));
    }


    protected function DoSubmit(){

        if(!$this->comments->usersTest11->isUserActive())
            $this->comments->errorOutput->setMessage(['msg' => 'You need to login to use this function', 'title' => 'Login']);


        if(!is_null($this->comment)) {
            $this->comment->comment = $this->Value('commentArea');
            $this->comment->save();
        }

        else {


            $now = time();
            $data = [
                'qID' => $this->qID,
                'userID' =>  $this->userID,
                'username' => $this->username,
                'comment' =>  $this->Value('commentArea'),
                'timestamp' => $now,
                'votes' => 0,
            ];

            $this->comments->save($data);
        }
        return true;

    }


}