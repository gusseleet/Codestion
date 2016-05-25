<h1><?=$title?></h1>

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php foreach ($users as $user) : ?>
            <th scope="row"> <?=$user->id?> </th>
            <td><a href="<?=$this->url->create('users/profile/' . $user->id)?>"> <?=$user->username?></a></td>
            <td><?=$user->email?></td>
        </tr>
            <?php endforeach ?>
        </tbody>
    </table>
