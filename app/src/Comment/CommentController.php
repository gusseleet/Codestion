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

        $this->answers = new \gel\Comment\AnswersToComments();
        $this->answers->setDI($this->di);


        $this->votes = new \gel\Comment\Votes();
        $this->votes->setDI($this->di);
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

    public function answerCommentAction($commentID, $qID){

        $form = new \gel\Comment\CAnswerForm($commentID, $this->session->get('user')['id'], $this->answers);
        $form->setDI($this->di);
        $this->theme->setTitle('Answer comment');
        $status = $form->Check();

        if($status === true) {
            $url = $this->url->create('questions/view/' . $qID);
            $this->response->redirect($url);
        }

        $this->views->add('comment/form', [
            'html' => $form->getHTML(),
            'title' => 'Answer'
        ]);

    }

    public function getCommentsAction($qID = null, $sortBY = 0){

        $comments = $this->comments->getComments($qID, $sortBY);
        $commentsAndAnswers = $this->answers->getCommentsToAnswer($comments);



        $this->views->add('comment/comments', [
            'comments' => $commentsAndAnswers,
            'answers' => null,
            ]);

    }


    public function getCommentsByUserAction($userID = null){

        $comments = $this->comments->getCommentsMadeMyUser($userID);

        $this->views->add('comment/commentsOnlyTitle', [
            'comments' => $comments,
        ],'triptych-2');

    }

    public function getCommentsToAnswersAction($userID = null){

        $answers = $this->comments->getCommentsToAnswersMadeByUser($userID);

        $this->views->add('comment/commentsToAnswersOnylTitle', [
            'comments' => $answers,
        ],'triptych-3');
    }



    //TODO: Implement that a user can only vote up one and down one (and must be verified)

    /**
     * Adding a vote to a comment
     * @param int $commentID Id of a comment
     */

    public function addVoteAction($commentID, $whatVote){


        if($this->votes->addVoteAnswer($commentID, $whatVote)){
            $comment = $this->comments->find($commentID);
            $comment->votes = $comment->votes + 1;
            $comment->save();

            $url = $this->url->create('questions/view/'.end(explode("/", $_SERVER["HTTP_REFERER"])));
            $this->response->redirect($url);

        } else
            $this->errorOutput->setMessage(['msg' => 'What are you doing... Trying to break the system?', 'title' => 'You can only vote one time']);



    }


    //TODO: Implement that a user can only vote up one and down one (and must be verified)

    /**
     * @param $commentID
     */

    public function removeVoteAction($commentID, $whatVote){


        if($this->votes->removeVoteAnswer($commentID, $whatVote)){
            $comment = $this->comments->find($commentID);
            $comment->votes = $comment->votes  -1;
            $comment->save();

            $url = $this->url->create('questions/view/'.end(explode("/", $_SERVER["HTTP_REFERER"])));
            $this->response->redirect($url);


        } else
            $this->errorOutput->setMessage(['msg' => 'What are you doing... Trying to break the system?', 'title' => 'You can only vote one time']);



    }


    public function markAsAnswerAction($commentID){

        $qID = end(explode("/", $_SERVER["HTTP_REFERER"]));
        /*$comment = $this->comments->find($qID, $commentID);
        $comment->marked = true;
        $comment->save();*/

        $this->comments->markAsAnswer($qID, $commentID);

        $url = $this->url->create('questions/view/'. $qID);
        $this->response->redirect($url);
    }


    /**
     * Add a comment.
     *
     * @return void
     */
    public function addAction($qID = null, $userId = null, $username = null)
    {

        $form = new \gel\Comment\CCommentForm(null, $this->comments, $userId, $qID, $username);


        $this->theme->setTitle('Comments');
        $status = $form->Check();

        if($status === true) {
            $url = $this->url->create('questions/view/' . $qID);
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
                'userID' => ['integer'],
                'username' => ['varchar(100)'],
                'web' => ['varchar(80)'],
                'mail' => ['varchar(80)'],
                'timestamp' => ['integer'],
                'ip' => ['varchar(80)'],
                'votes' => ['integer'],
                'qID' => ['integer'],
            ]
        )->execute();

        $this->db->insert('comments',
            ['comment', 'userID','username', 'web', 'mail', 'timestamp','ip', 'votes', 'qID']);

        $this->db->execute([
            "Comment1",
            1,
            'gel',
            "?",
            "ais@greek.old",
            time(),
            $this->request->getServer('REMOTE_ADDR'),
            10,
            1
        ]);


        $this->db->execute([
            "Comment2",
            1,
            'gel',
            "?",
            "winston@home.en",
            time(),
            $this->request->getServer('REMOTE_ADDR'),
            8,
            1
        ]);

        $this->db->execute([
            "Comment3",
            2,
            'doe',
            "?",
            "cessar@rome.old",
            time(),
            $this->request->getServer('REMOTE_ADDR'),
            4,
            2
        ]);


    }
}
