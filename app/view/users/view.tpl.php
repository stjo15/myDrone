<h2><?=$title?></h2>

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
    $active = null;
    $activetext = null;
    if (isset($user->active)) {
        $active = 'inactivate';
        $activetext = 'Inaktivera';
    } else {
        $active = 'activate';
        $activetext = 'Aktivera';
    }
?>

<img class='gravatar' src='<?=$user->gravatar?>?s=120' alt='gravatar'> 
<h4 class='xp'><i class="fa fa-trophy fa-2x gold"></i> <?=$user->xp?></h4>

<ul> 
    <li>Id: <?=$user->id?></li>
    <li>Akronym: <?=$user->acronym?></li>
    <li>E-post: <a href="mailto:<?=$user->email?>"><?=$user->email?></a></li>
    <li>Namn: <?=$user->name?></li>
    <li>Skapad: <?=$user->created?></li>
    <li>Uppdaterad: <?=$user->updated?></li>
    <li>Raderad: <?=$user->deleted?></li>
    <li>Aktiv: <?=$user->active?></li>
    <hr>
    <?php if(isset($_SESSION['user'])): ?> 
        <?php if(($_SESSION['user']->acronym == $user->acronym) || ($_SESSION['user']->acronym == 'admin')): ?>
        
        <li><a href='<?=$this->url->create('users/' . $active . '/' . $user->id)?>'><?=$activetext?></a></li>
        <li><a href='<?=$this->url->create('users/update/' . $user->id)?>'>Redigera</a></li>
        <li><a href='<?=$this->url->create('users/' . $deletetype . '/' . $user->id)?>'><?=$deletetext?></a></li>
        
        <?php endif; ?>
    <?php endif; ?>
</ul> 

<?php if(isset($_SESSION['user']) && $_SESSION['user']->acronym == 'admin'): ?>

    <hr>
    
    <h4>Administratörspanel</h4>
    <table class='admin'>
        <tr>
            <th>Användare</th>
            <th>RSS-flöden</th>
            <th>Databas</th>
        </tr>
        <tr>
            <td>
                <ul>
                    <li><a href='<?=$this->url->create('users/add')?>'>Lägg till ny användare</a></li>
                    <li><a href='<?=$this->url->create('users/list')?>'>Visa alla användare</a></li>
                    <li><a href='<?=$this->url->create('users/active')?>'>Visa alla aktiva</a></li>
                    <li><a href='<?=$this->url->create('users/inactive')?>'>Visa alla inaktiva</a></li>
                    <li><a href='<?=$this->url->create('users/soft-deleted')?>'>Visa papperskorgen</a></li>
                </ul>
            </td>
            
            <td>
                <ul>
                    <li><a href='<?=$this->url->create('rss/setup')?>'>Skapa nytt RSS-flöde</a></li>
                    <li><a href='<?=$this->url->create('rss/list')?>'>Visa alla RSS-flöden</a></li>
                </ul>
            </td>
        </tr>
            
     </table>

<?php endif; ?>