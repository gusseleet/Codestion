<hr>
<h4> Most active users</h4>
<ul class="list-group">
<?php foreach ($users as $user) : ?>

<li class="list-group-item"><a href="<?=$this->url->create('users/profile/' . $user->uID)?>"><?=$this->usersTest11->getUserByID($user->uID)->username?> </a>
    <span class="badge"> <?=$this->usersTest11->getScore($user->uID)?></span>
</li>

<?php endforeach ?>
</ul>