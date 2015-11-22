<h4><?=$title?></h4>

<?php if (is_array($tags)) : ?>

<ol class='sidebar-list'>
<?php foreach ($tags as $id => $tag) : ?>
<?php $id = (is_object($tag)) ? $tag->id : $id; ?>
<?php $tag = (is_object($tag)) ? get_object_vars($tag) : $tag; ?>
<?php $questions = $tag['questions'] == 1 ? ' fråga' : ' frågor'; ?>
    <li><span class='tag-label'><a href='<?=$this->url->create('question/list/'.$tag['slug'])?>'><?=$tag['name']?></a></span>: <?=$tag['questions'].$questions?></li>

<?php endforeach; ?>
<?php endif; ?>
</ol>
