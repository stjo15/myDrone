<h2><?=$title?></h2>

<table> 

<tr><th>Id</th><th>Akronym</th><th>E-post</th><th>Namn</th><th>Skapad</th></tr>
<?php foreach ($users as $user) : ?>

<?php 
    $deletetype = null;
    $deletetext = null;
    if (isset($user->deleted)) {
        $deletetype = 'delete';
        $deletetext = 'Radera permananent';
    } else {
        $deletetype = 'soft-delete';
        $deletetext = 'Radera';
    }
?>

    <tr>
            <td><?=$user->id?></td>
            <td><?=$user->acronym?></td>
            <td><a href="mailto:<?=$user->email?>"><?=$user->email?></a></td>
            <td><?=$user->name?></td>
            <td><?=$user->created?></td>
            <td>|</td>
            <td><a href='<?=$this->url->create('users/id/' . $user->id)?>'>Visa</a></td>
            <td>|</td>
            <td><a href='<?=$this->url->create('users/update/' . $user->id)?>'>Redigera</a></td>
            <td>|</td>
            <td><a href='<?=$this->url->create('users/' . $deletetype . '/' . $user->id)?>'><?=$deletetext?></a></td>
    </tr>
<?php endforeach; ?>
</table> 