<hr>
<h4> Most popular tags</h4>
<?php foreach ($tags as $tag) : ?>

    <a class ="tagsListAll" href="<?=$this->url->create('questions/tag/' . $tag)?>"> <?=$tag?></a>

<?php endforeach ?>
