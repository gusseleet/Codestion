<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-05-15
 * Time: 18:48
 */

namespace gel\Questions;


class Question extends \Anax\MVC\CDatabaseModel
{

    use \Anax\DI\TInjectable;


    /**
     * @param $id int id on what comment should be used.
     * @return mixed
     */

    public function getQuestion($qID){

        $params = [$qID];

        $question = $this->query()
            ->where('id = ?')
            ->execute($params);

        return $question;
    }


    /**
     * Select a user based on a ID (from databse) and then use it.
     * @param $id int id on what user should be used.
     * @return mixed
     */

    public function getUser($id){

        return $this->UsersController->getUser($id);
    }


    /**
     * Control if the user is active.
     * @return boolean
     */
    public function isUserActive(){

        //return $this->UserController->isUserActive();
    }


    public function getAllInfoToAQuestion(){


        $data = [
            'userID' => $this->usersTest11->getLoggedInUser()['id'],
            'username' => $this->usersTest11->getOnlyUserName($this->usersTest11->getLoggedInUser()['id']),

        ];

        return $data;
    }


    public function getQuestionAskedByUser($id){

        $params = [$id];

        $questions = $this->query()
            ->where('op = ?')
            ->execute($params);

        return $questions;
    }




    public function getAllQuestionByTag($tag){

        $params = ['%' . $tag . '%'];

        $questions = $this->query()
            ->where('tags LIKE ?')
            ->execute($params);

        return $questions;

    }

}