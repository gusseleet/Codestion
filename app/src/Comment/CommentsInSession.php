<?php

namespace gel\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentsInSession implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    const ORG_PATH = 'comments';


    /**
     * Add a new comment.
     *
     * @param array $comment with all details.
     * @param string $which with what comment-section should be used
     * @return void
     */
    public function add($comment, $fieldID)
    {


        $allComments = $this->session->get(CommentsInSession::ORG_PATH, []);
        if(array_key_exists($fieldID, $allComments))
             $pageComments = $allComments[$fieldID];

        $pageComments[] = $comment;
        $allComments[$fieldID] = $pageComments;

        $this->session->set(CommentsInSession::ORG_PATH, $allComments);
    }


    /**
     * Find and return all comments.
     *
     * @return array with all comments.
     */
    public function findAll($fieldID)
    {


        $allComments = $this->session->get(CommentsInSession::ORG_PATH, []);

        if(array_key_exists($fieldID, $allComments))
            $pageComments = $allComments[$fieldID];
        else
            $pageComments = null;



        return $pageComments;
    }



    /**
     * Delete all comments.
     *
     * @return void
     */
    public function deleteAll()
    {
        $this->session->set(CommentsInSession::ORG_PATH, []);

    }



    public function delete($id, $fieldID){


        $this->session->_unset(CommentsInSession::ORG_PATH ,$fieldID, $id);

    }



    public function find($id, $fieldID) {

        $allComments = $this->session->get(CommentsInSession::ORG_PATH, []);
        $pageComments = $allComments[$fieldID];
        return $pageComments[$id];

    }

    public function update($id, $comment, $fieldID = null) {


        $allComments = $this->session->get(CommentsInSession::ORG_PATH, []);
        $pageComments = $allComments[$fieldID];

        $pageComments[$id] = $comment;
        $allComments[$fieldID] = $pageComments;

        $this->session->set(CommentsInSession::ORG_PATH, $allComments);

    }

}