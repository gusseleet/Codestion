<h1><?=$user->name?></h1>
<div class="container">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td>ID</td>
            <td><?=$user->id?></td>

        </tr>
        <tr>
            <td>Acronym</td>
            <td><?=$user->acronym?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?=$user->email?></td>
        </tr>
        <tr>
            <td>Created</td>
            <td><?=$user->created?></td>
        </tr>
        <tr>
            <td>Active</td>
            <td><?=$user->active?></td>
        </tr>
        </tbody>
    </table>
</div>

<a class="btn btn-default" href="<?=$this->url->create('users')?>" role="button" data-toggle="Testing" title="This will reset the whole database!">Back</a>
