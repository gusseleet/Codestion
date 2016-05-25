<?php if (is_array($comments)) : ?>
<a class="list-group-item active"> Answers (<?=sizeof($comments)?>) </a>
        <?php foreach ($comments as $id => $comment) : ?>
          <a class ="list-group-item" href="<?=$this->url->create('questions/view/' . $comment->qID)?>"><?=$comment->comment ?> </a>
        <?php endforeach; ?>
<?php endif; ?>

