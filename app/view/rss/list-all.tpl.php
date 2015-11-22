<h2><?=$title?></h2>

<table> 

<tr><th>Id</th><th>Sidnyckel</th><th>Titel</th><th>Beskrivning</th></tr>
<?php foreach ($feeds as $feed) : ?>

    <tr>
            <td><?=$feed->id?></td>
            <td><?=$feed->pagekey?></td>
            <td><?=$feed->title?></td>
            <td><?=$feed->description?></td>
            <td>|</td>
            <td><a href='<?=$this->url->create('rss/view/' . $feed->pagekey)?>'>Visa</a></td>
            <td>|</td>
            <td><a href='<?=$this->url->create('rss/update/' . $feed->id)?>'>Redigera</a></td>
            <td>|</td>
            <td><a href='<?=$this->url->create('rss/delete/' . $feed->id . '/' . $feed->pagekey)?>'>Radera</a></td>
    </tr>
<?php endforeach; ?>
</table> 