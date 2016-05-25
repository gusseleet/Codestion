<a href="<?=$this->url->create('questions/removeVote/' . $sq->id . '/q')?>" class="voteButtons">
    <i class="fa fa-arrow-circle-down fa-2x" aria-hidden="true"></i></a>

<h3 class="rank"><?=$sq->votes?></h3>

<a href="<?=$this->url->create('questions/addVote/' . $sq->id . '/q')?>" class="voteButtons">
    <i class="fa fa-arrow-circle-up fa-2x"></i></a>

<h1><?=$sq->title?></h1>

<p><?=$this->textFilter->doFilter($sq->body, 'markdown')?></p>

<p>By <?=$user?> </p>

<?=dump($comments)?>
