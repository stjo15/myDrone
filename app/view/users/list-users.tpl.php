<h2><?=$title?></h2>
<ul>
<?php foreach ($users as $user) : ?>

    <li class='tag-list'>
    <a href='<?=$this->url->create('users/id/' . $user->id)?>'>
    <div class='user'> 
        <p><?=$user->name?></p>
        <img class='gravatar' src='<?=$user->gravatar?>?s=60' alt='gravatar'>
        <p><?=$user->xp?> <i class="fa fa-trophy fa-2x gold"></i></p>
    </div>
    </a>
    </li>

<?php endforeach; ?>
</ul>