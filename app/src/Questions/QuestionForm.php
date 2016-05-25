<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-05-15
 * Time: 19:10
 */

namespace gel\Questions;
use Mos\HTMLForm\CFormElementCheckboxMultiple;
use Mos\HTMLForm\CFormElementSelectMultiple;
use Mos\HTMLForm\CFormElementSubmit;
use Mos\HTMLForm\CFormElementText;
use Mos\HTMLForm\CFormElementTextarea;

class QuestionForm extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;



    public function __construct($question, $id = null, $TCTQ)
    {

        $this->test = $question;
        $this->id = $id;
        $this->TCTQ = $TCTQ;
        parent::__construct();

        $this->addElement(new CFormElementText('Title', array('value' => '', 'class' => 'form-control')))
            ->addElement(new CFormElementTextarea('commentArea', [
                  'value' => '',
                  'rows' => '10',
                  'cols' => '50',
                  'label' => 'Type your questions',
                  'required' => true,
                   'class' => 'form-control'
              ]))
           ->addElement(new CFormElementSelectMultiple('Tags', ['options' => [
               'php',
               'c++',
               'Java',
               'JavaScript',
               'Python',
               'C#',
           ], 'class' => 'form-control',
           ]))
            ->addElement(new CFormElementSubmit('Ask', array('callback' => array($this, 'DoSubmit'), 'class' => 'btn btn-md btn-primary')));

    }


    protected function DoSubmit(){

        $now = gmdate('Y-m-d H:i:s');

        $tags = $this->value('Tags');

        $data = [
            'op' => $this->id,
            'title' => $this->Value('Title'),
            'body' => $this->Value('commentArea'),
            'created' => $now,
            'votes' => 0,

        ];
        $this->test->save($data);
        $idQ = $this->test->lastInsertedId();


        $test = null;
        foreach($tags as $tag) {
            $tag+=1;
            $test .= "({$idQ},{$tag}),";
        }
        $test = rtrim($test, ",");

        $sql = "INSERT INTO phpmvc_kmom04_tagsconnectedtoquestions(idQuestion, idTag) VALUES " . $test . ";";

        $this->test->db->execute($sql);

        return true;
    }


    public function getIdFromTag($tag){

        $possibleTags = [
            'nada',
            'php',
            'c++',
            'Java',
            'JavaScript',
            'Python',
            'C#',
        ];



        for($i = 1; $i < sizeof($possibleTags); $i++){
            if($tag == $possibleTags[$i])
                return $i;
        }

        return -1;
    }

}