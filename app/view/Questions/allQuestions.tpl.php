<h3> All Questions</h3>
<hr>
<?php foreach ($test as $question) : ?>

    Rank: <span class="badge"><?=$question->votes?></span>
    Answers: <span class="badge"><?=sizeof($this->commentModel->getComments($question->id))?></span>
    <br>
    <h6><a class='questionTitle' href="<?=$this->url->create('questions/view/' . $question->id)?>"> <?=$question->title?></a></h6>

    <br>
    <div class="well well-sm">
        <?=$this->textFilter->doFilter($question->body,'markdown')?>
    </div>
    <?php $q = explode(",", $question->tags) ?>

    <?php foreach ($q as $qT) : ?>
        <a class ='tagsListAll' href="<?=$this->url->create('questions/tag/' . $qT)?>"> <?=$qT?></a>
    <?php endforeach ?>
    <br><br>
    <hr>
<?php endforeach ?>

