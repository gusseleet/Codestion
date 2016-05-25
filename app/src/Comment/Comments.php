<?php
namespace gel\Comment;

class Comments extends \Anax\MVC\CDatabaseModel
{


    public function getComments($id, $sortBY = 0){

        $sort = 'VOTES';

        if($sortBY == 1)
            $sort = 'timestamp';


        $params = [$id];

        $comments = $this->query()
            ->where('qID = ?')
            ->orderBy($sort . ' DESC')
            ->execute($params);

        return $comments;

    }


    public function getCommentsMadeMyUser($id){

        $params = [$id];

        $comments = $this->query()
            ->where('userID = ?')
            ->orderBy('votes DESC')
            ->execute($params);

        return $comments;

    }

    public function getCommentsToAnswersMadeByUser($id){

        return $this->answerToCommentsModel->getCommentsByUser($id);

    }


    public function markAsAnswer($qID, $cID){

        if(!$this->usersTest11->isUserActive())
            $this->errorOutput->setMessage(['msg' => 'What are you doing... Trying to break the system?', 'title' => 'You need to be logged in']);


        if($this->questionModel->getQuestion($qID)[0]->op != $this->usersTest11->getLoggedInUser()['id'])
            $this->errorOutput->setMessage(['msg' => 'What are you doing... Trying to break the system?', 'title' => 'You aint OP!']);



        $comment = $this->query()
            ->where('marked = 1')
            ->andWhere('qID = ?')
            ->execute([$qID]);

        if(!empty($comment)) {
            $comment[0]->marked = false;
            $this->save($comment[0]);
        }


        $comment = $this->query()
            ->where('id = ?')
            ->execute([$cID]);

        $comment[0]->marked = true;
        $this->save($comment[0]);

    }




}