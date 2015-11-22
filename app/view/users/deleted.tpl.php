<h2><?=$title?></h2>
<table> 

<tr><th>Id</th><th>Akronym</th><th>E-post</th><th>Namn</th><th>Skapad</th></tr>
<?php foreach ($users as $user) : ?>
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
            <td><a href='<?=$this->url->create('users/delete/' . $user->id)?>'>Radera permanent</a></td>
            <td>|</td>
            <td><a href='<?=$this->url->create('users/restore/' . $user->id)?>'>Återställ</a></td>
    </tr>
<?php endforeach; ?>
</table> 

<hr>

<p><a href='<?=$this->url->create('users/add')?>'>Lägg till ny användare</a></p>
<p><a href='<?=$this->url->create('users')?>'>Visa alla användare</a></p>
<p><a href='<?=$this->url->create('users/active')?>'>Visa alla aktiva</a></p>
<p><a href='<?=$this->url->create('users/inactive')?>'>Visa alla inaktiva</a></p>
<p><a href='<?=$this->url->create('users/soft-deleted')?>'>Visa papperskorgen</a></p>
