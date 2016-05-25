
<hr>
<h3> Latest questions</h3>
<?php foreach ($questions as $question) : ?>

    Rank: <span class="badge"><?=$question->votes?></span>
    Answers: <span class="badge"><?=sizeof($this->commentModel->getComments($question->id))?></span>
    <br>
    <h6><a class='questionTitle' href="<?=$this->url->create('questions/view/' . $question->id)?>"> <?=$question->title?></a></h6>
    <?php if(strlen($question->body) >= 100) : ?>
        <?php  $question->body = substr($question->body, 0, strpos($question->body, ' ', 100));
        $question->body .= "...";?>

    <?php endif;?>
    <br>
    <div class="well well-sm">
        <?=$this->textFilter->doFilter($question->body,'markdown')?>
    </div>
    <?php $q = explode(",", $question->tags) ?>
    <br>
    <?php foreach ($q as $qT) : ?>
        <a class ='tagsListAll' href="<?=$this->url->create('questions/tag/' . $qT)?>"> <?=$qT?></a>
    <?php endforeach ?>
    <hr>
<?php endforeach ?>

