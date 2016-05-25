<?php
/**
 * Created by PhpStorm.
 * User: Gustav
 * Date: 2016-05-21
 * Time: 09:36
 */

namespace gel\Comment;


class Comment extends Comments
{

    public function getComments($id){

        $params = [$id];

        $comments = $this->query()
            ->where('qID = ?')
            ->orderBy('votes DESC')
            ->execute($params);

        return $comments;

    }

}