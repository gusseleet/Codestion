<a class="list-group-item active">Comments (<?=sizeof($comments)?>) </a>
<div class="list-group">
<?php foreach ($comments as $comment) : ?>
    <?dump($comment)?>
    <a class="list-group-item"><?=$comment->body?></a>
<?php endforeach ?>
</div>