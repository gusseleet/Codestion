<?php

namespace gel\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    public function initialize(){

        $this->comments = new \gel\Comment\Comments();
        $this->comments->setDI($this->di);
    }

    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction($qID = null)
    {

        $all = $this->comments->query()
            ->orderBy('votes DESC')
            ->execute();

        $this->views->add('comment/comments', [
            'comments' => $all,
            'title' => 'Comments',
        ]);



    }


    public function getComments($qID = null){



        $test = new \gel\Comment\Comments();
        $test->setDI($this->di);

        $params = [$qID];

        $comments = $test->query()
            ->where('qID = ?')
            ->orderBy('votes DESC')
            ->execute($params);

        $this->views->add('comment/comments', [
            'comments' => $comments,
        ]);


        //return $this->comments
    }



    //TODO: Implement that a user can only vote up one and down one (and must be verified)

    /**
     * Adding a vote to a comment
     * @param int $commentID Id of a comment
     */

    public function addVoteAction($commentID){

        $comment = $this->comments->find($commentID);
        $comment->votes = $comment->votes + 1;
        $comment->save();

        $url = $this->url->create('comments');
        $this->response->redirect($url);
    }


    //TODO: Implement that a user can only vote up one and down one (and must be verified)

    /**
     * @param $commentID
     */

    public function removeVoteAction($commentID){

        $comment = $this->comments->find($commentID);
        $comment->votes = $comment->votes  -1;
        $comment->save();

        $url = $this->url->create('comments');
        $this->response->redirect($url);

    }



    /**
     * Add a comment.
     *
     * @return void
     */
    public function addAction()
    {

        $form = new \gel\Comment\CCommentForm(null, $this->comments);


        $this->theme->setTitle('Comments');
        $status = $form->Check();

        if($status === true) {
            $url = $this->url->create('comments');
            $this->response->redirect($url);
        }


        $this->views->add('comment/form', [
            'html' => $form->getHTML(),
            'title' => 'Post new reply'
        ]);

    }


    /**
     * Edit a comment
     *
     * @param int $id id of the current comment
     * @param null $formID
     * @throws \Exception
     */


    public function editAction($id, $formID = null) {

        $this->theme->setTitle('Edit comment');
        $comment = $this->comments->find($id);

        $form = new \gel\Comment\CCommentForm($comment);


        $status = $form->Check();

        if($status === true) {
            $url = $this->url->create('comments');
            $this->response->redirect($url);
        }

        $this->views->add('comment/form',[
           'html' => $form->getHTML(),
            'title' => 'Edit',
        ]);

    }

    /**
     * Remove a single comment
     * @param int $id id of the current comment
     * @param null $formID
     * @throws \Exception
     */

    public function removeSingleAction($id, $formID = null) {


        $this->comments->delete($id);
        $url = $this->url->create('comments');
        $this->response->redirect($url);

    }

    /**
     * Setup comments to a default state.
     *
     */

    public function setupAction(){

        $this->db->dropTableIfExists('comments')->execute();

        $this->db->createTable(
            'comments',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'comment' => ['varchar(255)'],
                'name' => ['varchar(80)'],
                'web' => ['varchar(80)'],
                'mail' => ['varchar(80)'],
                'timestamp' => ['integer'],
                'ip' => ['varchar(80)'],
                'votes' => ['integer'],
                'qID' => ['integer'],
            ]
        )->execute();

        $this->db->insert('comments',
            ['comment', 'name', 'web', 'mail', 'timestamp','ip', 'votes', 'qID']);

        $this->db->execute([
            "Comment1",
            "User1",
            "?",
            "ais@greek.old",
            time(),
            $this->request->getServer('REMOTE_ADDR'),
            10,
            1
        ]);


        $this->db->execute([
            "Comment2",
            "User12",
            "?",
            "winston@home.en",
            time(),
            $this->request->getServer('REMOTE_ADDR'),
            8,
            1
        ]);

        $this->db->execute([
            "Comment3",
            "User3",
            "?",
            "cessar@rome.old",
            time(),
            $this->request->getServer('REMOTE_ADDR'),
            4,
            2
        ]);


    }
}
