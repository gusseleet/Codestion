<?php
namespace Anax\Users;

/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\CDatabaseModel
{

    use \Anax\DI\TInjectable;

    public function userLogin($cred){

        $user = $this->confirmPassword($cred['username'], $cred['password']);
        if($user != null){
            $this->loginUserInSession($user);
            $url = $this->url->create('users/profile/'.$user->id);
            $this->response->redirect($url);
        } else {


        }

    }


    public function getOnlyUserName($id){


        $res = $this->query()
            ->where("id = ?")
            ->execute([$id]);

        return isset($res[0]->username) ? $res[0]->username : null;
    }

    public function getUserByName($username){

         $res = $this->query()
                ->where("username = ?")
                ->execute([$username]);

        return isset($res[0]) ? $res[0] : null;
    }



    public function getLoggedInUser(){

        return $this->session->get('user');

    }

    public function getUserByID($id){

         $res = $this->query()
                ->where("id = ?")
                ->execute([$id]);

        return isset($res[0]) ? $res[0] : null;
    }

    public function confirmPassword($username, $password) {

       $res = $this->getUserByName($username);
        if(empty($res)) {
            $this->errorOutput->setMessage(['type' => 'error', 'msg' => 'There is no user with that credentials', 'title' => 'Wrong input']);
        }
        if((password_verify($password, $res->password)))
            return $res;
         else
            return null;

    }


    public function userLogout(){

        $this->session->_unset('user');
        $url = $this->url->create('');
        $this->response->redirect($url);

    }

    public function loginUserInSession($user){

        $this->session->set('user',
            [
                'verified'  => true,
                'type'      => 'admin',
                'id'        => $user->id,

            ]);
    }


    public function isUserActive(){
        return $this->di->session->has('user');
    }



    public function getCorrectUrl(){

        if($this->isUserActive()){
            return [
                'text' => 'Logout',
                'url' => 'users/logout',
                'title' => 'Logout',
            ];
        }


        return [
            'url' => 'users/login',
            'text' => 'Login',
            'title' => 'Login',
        ];
    }


    public function getCommentsByUser(){



    }


    public function getScore($id){

        $pointsQ    =   $this->questionModel->getQuestionAskedByUser($id);
        $pointsA    =   $this->commentModel->getCommentsMadeMyUser($id);
        $pointsC    =   $this->answerToCommentsModel->getCommentsByUser($id);
        $pointsV    =   $this->votesModel->getVotesByUser($id);

        return sizeof($pointsA) + sizeof($pointsQ) + sizeof($pointsC) + sizeof($pointsV);

    }


    public function getMostActiveUsersLimit($limit){

        $sql = "

    SELECT       `uID`,
             COUNT(`aID`) + COUNT(`cID`) + COUNT(`qID`) AS `raiting`
    FROM     `phpmvc_kmom04_votes`
    WHERE uID IS NOT NULL
    GROUP BY `uID`
    ORDER BY `raiting` DESC
    LIMIT 3;";


        $res = $this->db->executeFetchAll($sql);


        return $res;

    }

    public function ownProfile($id){

        if ($this->di->session->get('user')['id'] == $id){
            return true;
        } else
           return false;


    }
}