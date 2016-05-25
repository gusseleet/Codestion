


<p class="userTitle"> <?=$title?> <span class="badge"><?=$score?></span>
<?php if($ownProfile)  : ?>
        <a  class="edit" href="<?=$this->di->url->create('users/edit/' . $id)?>">
        <i class="fa fa-cog" aria-hidden="true"></i></a>
<?php endif;?>


<br>
<br>
<img class="img-rounded" src="<?=$gravatar?>">
        <br>
        <br>
<div class="well">
<p class="profileText"> <?=$bio?> </p>
</div>

