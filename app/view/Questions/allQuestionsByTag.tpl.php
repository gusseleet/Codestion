
<pre>
</pre>

<hr class ="answers">
<?php foreach ($questions as $question) : ?>
    <a class='questionTitle' href="<?=$this->url->create('questions/view/' . $question->id)?>"> <?=$question->title?></a>
    <?php if(strlen($question->body) >= 100) : ?>
        <?php  $question->body = substr($question->body, 0, strpos($question->body, ' ', 100));
        $question->body .= "...";?>
    <?php endif;?>
    <br>
    <div class="bodyMain">
        <?=$question->body?>
    </div>
    <?php $q = explode(",", $question->tags) ?>
    <br>
    <?php foreach ($q as $qT) : ?>
        <a class ='tagsListAll' href="<?=$this->url->create('questions/tag/' . $qT)?>"> <?=$qT?></a>
    <?php endforeach ?>
    <hr class ="answers">
<?php endforeach ?>