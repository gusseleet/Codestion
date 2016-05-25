<?php if (is_array($test)) : ?>
<a class="list-group-item active"> Questions (<?=sizeof($test)?>) </a>
<div class="list-group">
    <?php foreach ($test as $question) : ?>

        <a class = "list-group-item" href="<?=$this->url->create('questions/view/' . $question->id)?>"> <?=$question->title?></a>
    <?php endforeach ?>
<?php endif; ?>
</div>
