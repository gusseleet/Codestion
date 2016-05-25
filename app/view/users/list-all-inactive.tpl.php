<h1><?=$title?></h1>
<br>
<br>
<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>Acronym</th>
        <th>Email</th>
        <th>Username</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <?php foreach ($users as $user) : ?>
        <th scope="row"> <?=$user->id?> </th>
        <td><?=$user->acronym?></td>
        <td><?=$user->email?></td>
        <td><?=$user->name?></td>
        <td> <a class="btn btn-default" href="<?=$this->url->create('users/activate/' . $user->id)?>" role="button">Activate</a> </td>
        <td> <a class="btn btn-default" href="<?=$this->url->create('users/delete/' . $user->id)?>" role="button">Remove</a> </td>
        <td> <a class="btn btn-default" href="<?=$this->url->create('users/edit/' . $user->id)?>" role="button">Update</a> </td>
        <td> <a class="btn btn-default" href="<?=$this->url->create('users/id/' . $user->id)?>" role="button">More</a> </td>
    </tr>
    <?php endforeach ?>
    </tbody>


</table>

<a class="btn btn-default" href="<?=$this->url->create('users')?>" role="button" data-toggle="Testing" title="This will reset the whole database!">Back</a>

