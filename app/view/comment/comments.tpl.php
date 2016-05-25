<?php if (is_array($comments)) : ?>
    <div class="btn-group" role="group" aria-label="...">
        <a href="<?=$this->url->create('questions/view/' . $comments[0]->qID . '/' . 1)?>" class="btn btn-default" role="button">Created</a>
        <a href="<?=$this->url->create('questions/view/' . $comments[0]->qID . '/' . 0)?>" class="btn btn-default" role="button">Rank</a>
    </div>
    <div class='comments'>
        <?php foreach ($comments as $id => $comment) : ?>
            <div class ='singleComment'>
                <?if($comment->marked == 1 ? $color = "green" : $color ="black");?>

                <a href="<?=$this->url->create('comment/markAsAnswer/' . $comment->id)?>" style="color: <?=$color?>">
                <i class="fa fa-check fa-2x" aria-hidden="true"></i></a>

                <a href="<?=$this->url->create('comment/removeVote/' . $comment->id . '/a')?>" class="voteButtons">
                    <i class="fa fa-arrow-circle-down fa-2x"></i></a>
                <h3 class="rank"><?=$comment->votes?></h3>
                <a href="<?=$this->url->create('comment/addVote/' . $comment->id . '/a')?>" class="voteButtons">
                    <i class="fa fa-arrow-circle-up fa-2x"></i></a>
                <h4>
                    Answer #<?=$id?>, by <?=$comment->username?>
                </h4>

                <p><?=$this->textFilter->doFilter($comment->comment, 'markdown') ?></p>

                <?php $test = new DateTime("@".$comment->timestamp); ?>

                <p class="commentDate"> answered  <?= $test->format('F d \a\t H:i')?>  </p>
                </div>

            <div class="commentsToAnswers">
                <?php if(isset($comment->answer)) : ?>
                    <hr>
                    <?php foreach ($comment->answer as $answer) : ?>
                        <?=$this->textFilter->doFilter($answer->body,'markdown')?> - <?=$this->usersTest11->getOnlyUserName($answer->userID)?> <hr>
                    <?php endforeach; ?>
                <?php endif;?>

            </div>


            <a href="<?=$this->url->create('comment/answerComment/' . $comment->id . '/' . $comment->qID)?>"> Add comment</a>
        <hr>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

