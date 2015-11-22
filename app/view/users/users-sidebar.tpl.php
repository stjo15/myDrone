<ul>
<li><a href='<?=$this->url->create('users/add')?>'>Lägg till ny användare</a></li>
<li><a href='<?=$this->url->create('users')?>'>Visa alla användare</a></li>
<li><a href='<?=$this->url->create('users/active')?>'>Visa alla aktiva</a></li>
<li><a href='<?=$this->url->create('users/inactive')?>'>Visa alla inaktiva</a></li>
<li><a href='<?=$this->url->create('users/soft-deleted')?>'>Visa papperskorgen</a></li>
<li><a href='<?=$this->url->create('setup')?>'>Initiera databastabellen 'users' (Obs! Alla sparade användare raderas!)</a></li>
</ul>