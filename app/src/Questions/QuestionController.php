<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-05-12
 * Time: 12:49
 */

namespace gel\Questions;

class QuestionController  implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    /**
     * Initialize the controller
     * @return void
     */

    public function initialize(){

        $this->questions = new \gel\Questions\ViewQuestions();
        $this->questions->setDI($this->di);

        $this->viewQuestions = new \gel\Questions\Question();
        $this->viewQuestions->setDI($this->di);

        $this->tagsConnectedToQuestion = new tagsConnectedToQuestions();
        $this->tagsConnectedToQuestion->setDI($this->di);

        $this->votes = new \gel\Comment\Votes();
        $this->votes->setDI($this->di);
    }


    /**
     * List all questions and add them to the view.
     * CDatabaseModel $all this is all questions in the database.
     *
     */

    //TODO: Implement that only title will be fetched.
    public function listAllQuestionsAction(){

        $all = $this->questions->findAll();
        $this->theme->setTitle('List of questions');
        $this->views->add('Questions/allQuestions', [
            'test' => $all,
        ]);

/*
        $all = $this->tagsConnectedToQuestion->getActiveTags();
        $this->views->add('Questions/allQuestionsTags', [
            'tags' => $all,
        ], 'sidebar');
*/
    }


    public function tagAction( $tag= null){

        $res = $this->questions->getAllQuestionByTag($tag);
        $all = $this->tagsConnectedToQuestion->getActiveTags();
        $this->theme->setTitle('Tags');


        $this->views->add('Questions/allQuestionsByTag', [
            'questions' => $res,
        ]);


        $this->views->add('Questions/allQuestionsTags', [
            'tags' => $all,
        ], 'sidebar');

    }



    public function addVoteAction($qId, $whatVote){


        if($this->votes->addVoteAnswer($qId, $whatVote)){
            $questions = $this->viewQuestions->find($qId);
            $questions->votes = $questions->votes  + 1;
            $questions->save();

            $url = $this->url->create('questions/view/'.end(explode("/", $_SERVER["HTTP_REFERER"])));
            $this->response->redirect($url);

        } else
            $this->errorOutput->setMessage(['msg' => 'What are you doing... Trying to break the system?', 'title' => 'You can only vote one time']);





    }


    public function removeVoteAction($qId, $whatVote){


        if($this->votes->removeVoteAnswer($qId, $whatVote)){
            $questions = $this->viewQuestions->find($qId);
            $questions->votes = $questions->votes  -1;
            $questions->save();

            $url = $this->url->create('questions/view/'.end(explode("/", $_SERVER["HTTP_REFERER"])));
            $this->response->redirect($url);

        } else
            $this->errorOutput->setMessage(['msg' => 'What are you doing... Trying to break the system?', 'title' => 'You can only vote one time']);


    }

    public function getTagsAction(){


        $all = $this->tagsConnectedToQuestion->getActiveTags();

        $this->theme->setTitle('Tags');

        $this->views->add('Questions/allQuestionsTags', [
            'tags' => $all,
        ]);

    }

    /**
     * @param $id int id in database on what question that will displayed. 
     * @return void 
     */
    
    //TODO: Implement dispatcher so function initialize will work, or solve it in another way.
    //Is it ok to show two views in a route?
    public function viewAction($id, $sortBY = 0){


        $question = $this->questions->find($id);

        $this->views->addString('Asked ' . $question->created, 'sidebar');

        $user =  $this->usersTest11->getUserByID($question->op);
        $data = $this->questions->getAllInfoToAQuestion();

       $this->views->add('Questions/singleQuestions', [
            'sq' => $question,
            'comments' => null,
            'user' => $user->username,
        ]);



        $this->dispatcher->forward([
            'controller' => 'Comment',
            'action' => 'getComments',
            'params' => [$id, $sortBY],
        ]);


      $this->dispatcher->forward([
            'controller' => 'Comment',
            'action' => 'add',
            'params' => [$id, $data['userID'], $data['username']],
        ]);



    }

    public function homepageAction(){

        $all = $this->questions->getQuestionsLimit(2);
        $this->theme->setTitle('Home');

        $allTags = $this->tagsConnectedToQuestion->getTagsLimit(1);


        $this->views->add('homepage/questions', [
            'questions' => $all,
        ],'triptych-1');

        $this->views->add('homepage/tags', [
            'tags' => $allTags,
        ],'triptych-2');


        $this->dispatcher->forward([
            'controller' => 'users',
            'action' => 'mostActiveUsers',
            'params' => [3],
        ]);

    }

    /**
     * Checks if the user is active. If the user is active creates a new form.
     * @return void
     */ 

    //TODO: Implement something if the user is not active, maybe some error output and redirect the user to homepage (?).
    public function askAction(){

        if(!$this->usersTest11->isUserActive())
            $this->errorOutput->setMessage(['msg' => 'What are you doing... Trying to break the system?', 'title' => 'You need to be logged in']);


        $this->theme->setTitle('Ask away');
        $form = new QuestionForm($this->viewQuestions, $this->session->get('user')['id'], $this->tagsConnectedToQuestion);

        $status = $form->Check();

        if($status === true) {
            $url = $this->url->create('questions');
            $this->response->redirect($url);
        }

        $this->views->add('Questions/questionForm', [
            'form' => $form->getHTML(),
        ]);

    }



    public function getQuestionByUserAction($id){

        $questions = $this->viewQuestions->getQuestionAskedByUser($id);

        $this->views->add('Questions/allQuestionsTitle', [
            'test' => $questions,
        ],'triptych-1');

    }

    /**
     * Setup questions in database with this hardcoded information.
     * @return void
     */
    public function setUpQuestionsAction(){

        $this->db->dropTableIfExists('question')->execute();

        $this->db->createTable(
            'question',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'op' => ['integer'],
                'title' => ['varchar(80)'],
                'body' => ['text'],
                'created' => ['datetime'],
                'updated' => ['datetime'],
            ]
        )->execute();


        $this->db->insert(
            'question',
            ['op', 'title', 'body', 'created']
        );

        $now = gmdate('Y-m-d H:i:s');

        $this->db->execute([
            '1',
            'Does this work',
            'HEHE COME ON NOW',
            $now,
        ]);

        $this->db->execute([
            '2',
            'If not, does this work',
            "BLALBLALBLALBA",
            $now,
        ]);


        $url = $this->url->create('');
        $this->response->redirect($url);

    }
}