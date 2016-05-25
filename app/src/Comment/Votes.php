<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-05-22
 * Time: 14:54
 */

namespace gel\Comment;


class Votes extends \Anax\MVC\CDatabaseModel
{

    use \Anax\DI\TInjectable;

    public function addVoteAnswer($id = null, $whatVote){

        if(!$this->usersTest11->isUserActive())
            $this->errorOutput->setMessage(['msg' => 'What are you doing... Trying to break the system?', 'title' => 'You need to be logged in']);



        if($whatVote == 'a')
            $whereSQL = "aID";


        if($whatVote =='c')
            $whereSQL = "cID";


        if($whatVote == 'q')
            $whereSQL = "qID";


        $userID = $this->usersTest11->getLoggedInUser()['id'];
        $params = [$id, $userID];

        $vote = $this->query()
            ->where($whereSQL . '= ?')
            ->andWhere('uID = ?')
            ->execute($params);

        if(empty($vote)){

            $data = [
                'uID' => $userID,
                $whereSQL => $id,
                'votes' => 1,
            ];

            $this->save($data);
            return true;
        } else if($vote[0]->votes == 0) {

            $vote[0]->votes = 1;
            $this->save($vote[0]);
            return true;
        } else if($vote[0]->votes == -1) {
            $vote[0]->votes = 0;
            $this->save($vote[0]);
            return true;

        }


        return false;
    }

    public function removeVoteAnswer($id = null, $whatVote){

        if(!$this->usersTest11->isUserActive())
            $this->errorOutput->setMessage(['msg' => 'What are you doing... Trying to break the system?', 'title' => 'You need to be logged in']);


        if($whatVote == 'a')
            $whereSQL = "aID";

        if($whatVote =='c')
            $whereSQL = "cID";


        if($whatVote == 'q')
            $whereSQL = "qID";



        $userID = $this->usersTest11->getLoggedInUser()['id'];
        $params = [$id, $userID];

        $vote = $this->query()
            ->where($whereSQL . '= ?')
            ->andWhere('uID = ?')
            ->execute($params);


        if(empty($vote)){

            $data = [
                'uID' => $userID,
                $whereSQL => $id,
                'votes' => 0,
            ];

            $this->save($data);
            return true;

        } else if($vote[0]->votes == 1) {

            $vote[0]->votes = 0;
            $this->save($vote[0]);
            return true;

        } else if($vote[0]->votes == 0) {
            $vote[0]->votes = -1;
            $this->save($vote[0]);
            return true;

        }


        return false;
    }


    public function getVotes($commentID){

        $params = [$commentID];

        $vote = $this->query()
            ->where('cID = ?')
            ->execute($params);

        return sizeof($vote);
    }


    public function getVotesByUser($id){

        $votes = $this->query()
            ->where('uID = ?')
            ->execute([$id]);

        return $votes;
    }
}