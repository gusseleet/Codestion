<?php

namespace Anax\Users;

/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    private $gravatar = null;

    public function __construct()
    {
        $this->gravatar = new \Anax\Users\CGravatar();
    }

    public function initialize(){

        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);


    }

    public function listAction(){


        $all = $this->users->findAll();

        $this->theme->setTitle('List of all users');

        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => 'All users',
        ]);

    }

    public function idAction($id = null) {


        $users = $this->users->find($id);

        $this->views->add('users/view',[
            'user' => $users,
        ]);
    }


    public function createAction($acronym = null) {

        $form = new \Anax\Users\CUserForm($this->users);
        $this->theme->setTitle("Create new user");

        $status = $form->Check();

        if($status === true) {
            $url = $this->url->create('users/login');
            $this->response->redirect($url);
        }


        $this->views->add('users/form', [
            'html' => $form->getHTML(),
        ]);

    }


    public function deleteAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }

        $res = $this->users->delete($id);

        $url = $this->url->create('users');
        $this->response->redirect($url);
    }


    public function activateAction($id){

        $now = gmdate('Y-m-d H:i:s');
        $user = $this->users->find($id);
        $user->active = $now;
        $user->save();

        $url = $this->url->create('users');
        $this->response->redirect($url);

    }

    public function softDeleteAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }

        $now = gmdate('Y-m-d H:i:s');

        $user = $this->users->find($id);

        $user->deleted = $now;
        $user->save();

        $url = $this->url->create('users');
        $this->response->redirect($url);
    }


    public function restoreAction($id = null) {

        $user = $this->users->find($id);

        $user->deleted = NULL;
        $user->save();

        $url = $this->url->create('users');
        $this->response->redirect($url);

    }
    public function activeAction()
    {
        $all = $this->users->query()
            ->where('active IS NOT NULL')
            ->andWhere('deleted is NULL')
            ->execute();

        $this->theme->setTitle("All users");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "Users",
        ]);
    }

    public function editAction($id = null){

        $this->theme->setTitle("Edit");

        if(!isset($id) || $this->users->getLoggedInUser()['id'] != $id){
            $this->errorOutput->setMessage(['msg' => 'What are you doing... Trying to break the system?', 'title' => 'No access']);
        }

        $user = $this->users->find($id);
        $form = new \Anax\Users\CUserEditForm($user);


        $status = $form->Check();

        if($status === true) {
            $url = $this->url->create('users/profile/' . $id);
            $this->response->redirect($url);
        }


        $this->views->add('users/form', [
            'html' => $form->getHTML(),
        ]);

    }


    public function inactiveAction(){

        $all = $this->users->query()
            ->where('active is NULL')
            ->execute();


        $this->views->add('users/list-all-inactive', ['users' => $all,
            'title' => "Users that are inactive"]);
    }

    public function showDeletedAction(){

        $all = $this->users->query()
            ->where('deleted is not null')
            ->execute();

        $this->views->add('users/list-all-deleted', ['users' => $all,
            'title' => 'Deleted']);
    }


    public function deactivateAction($id){


        $user = $this->users->find($id);

        $user->active = null;
        $user->save();

        $url = $this->url->create('users');
        $this->response->redirect($url);

    }


    public function setupUsersAction(){

        $this->db->dropTableIfExists('user')->execute();

        $this->db->createTable(
            'user',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'username' => ['varchar(20)', 'unique', 'not null'],
                'email' => ['varchar(80)'],
                'password' => ['varchar(255)'],
                'created' => ['datetime'],
                'updated' => ['datetime'],
                'deleted' => ['datetime'],
                'active' => ['datetime'],
                'role' => ['varchar(20)'],
                'gravatar' => ['varchar(255)']
            ]
        )->execute();


        $this->db->insert(
            'user',
            ['username', 'email', 'password', 'created', 'active', 'role', 'gravatar']
        );

        $now = gmdate('Y-m-d H:i:s');

        $this->db->execute([
            'gel',
            'gustavelmgren@gmail.com',
            password_hash('admin', PASSWORD_DEFAULT),
            $now,
            $now,
            'admin',
            'http://www.gravatar.com/avatar/1a21fc5b8bed6ba4802f07882c44991d?s=80&d=mm&r=g'
        ]);

        $this->db->execute([
            'doe',
            'doe@dbwebb.se',
            password_hash('doe', PASSWORD_DEFAULT),
            $now,
            $now,
            'user',
            'http://www.gravatar.com/avatar/1a21fc5b8bed6ba4802f07882c44991d?s=80&d=mm&r=g'
        ]);


        $url = $this->url->create('users');
        $this->response->redirect($url);

    }


    //TODO: Let a user have a aboutme-page, dont let the user change username/email.

    /*
    public function isUserActive(){
        return $this->di->session->has('user');
    }
    */


    //Question: select * from question where op = id
    //Frågor select * from comments where op = id
    //Svar: select * from answertocomments where op = id
    //Röstningar: select * from votes where op = id
    //


    public function mostActiveUsersAction(){

        $users = $this->users->getMostActiveUsersLimit(3);


        $this->views->add('homepage/users', [
            'users' => $users,
        ],'triptych-3');

    }

    public function profileAction($id){



        $user = $this->users->getUserByID($id);

        if(is_null($user))
            $this->errorOutput->setMessage(['msg' => 'There is no user with that credentials', 'title' => 'No user with that id']);


        $score = $this->users->getScore($id);

        $bool = $this->users->ownProfile($id);


        $this->views->add('users/profileSidebar',[], 'sidebar');


        $this->views->add('users/profile',
            [
                'title' => $user->username,
                'gravatar' =>  $user->gravatar,
                'urlEdit'   => null,
                'ownProfile' => $bool,
                'id'    => $user->id,
                'questions' => null,
                'comments' => null,
                'bio'       => $user->userProfileText,
                'score'     => $score,
            ]
        );

        $this->dispatcher->forward([
            'controller' => 'Comment',
            'action' => ' getCommentsByUser',
            'params' => [$id],
        ]);

        $this->dispatcher->forward([
            'controller' => 'Comment',
            'action' => ' getCommentsToAnswers',
            'params' => [$id],
        ]);


        $this->dispatcher->forward([
            'controller' => 'questions',
            'action' => ' getQuestionByUser',
            'params' => [$id],
        ]);

        $this->theme->setTitle('Din profil');




    }




    public function logoutAction(){

        $this->users->userLogout();
    }

    public function loginAction(){

        $loginForm = new \Anax\Users\loginForm($this->users);
        $this->theme->setTitle("Login");


        $this->views->add('users/log', [
            'form' => $loginForm->getHTML()
        ]);


    }

    public function getUser($id){

        $users = new \Anax\Users\User();
        $users->setDI($this->di);

        return $users->find($id);
    }
}