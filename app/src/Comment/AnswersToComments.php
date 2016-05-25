<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-05-20
 * Time: 17:30
 */

namespace gel\Comment;


class AnswersToComments extends \Anax\MVC\CDatabaseModel
{


    public function getCommentsToAnswer($comments){


        foreach($comments as $comment){
            $params = [$comment->id];
            $answer = $this->query()
                ->where('commentID = ?')
                ->execute($params);

            if(!empty($answer))
                $comment->answer = $answer;
        }

        return $comments;
    }


    public function getCommentsByUser($id){

        $answer = $this->query()
            ->where('userID = ?')
            ->execute([$id]);

        return $answer;
    }

}