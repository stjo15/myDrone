<h4><?=$title?></h4>

<?php if (is_array($users)) : ?>

<ol class='sidebar-list'>
<?php foreach ($users as $id => $user) : ?>
<?php $id = (is_object($user)) ? $user->id : $id; ?>
<?php $user = (is_object($user)) ? get_object_vars($user) : $user; ?>

    <li><a href='<?=$this->url->create('users/id/'.$id)?>'><?=$user['name']?></a>: <?=$user['xp']?> <i class="fa fa-trophy fa-1x gold"></i></li>

<?php endforeach; ?>
<?php endif; ?>
</ol>
