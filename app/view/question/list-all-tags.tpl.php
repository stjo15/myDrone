<h4><?=$title?></h4>

<?php if (is_array($tags)) : ?>

<ul>
<?php foreach ($tags as $id => $tag) : ?>
<?php $id = (is_object($tag)) ? $tag->id : $id; ?>
<?php $tag = (is_object($tag)) ? get_object_vars($tag) : $tag; ?>
<?php $questions = $tag['questions'] == 1 ? ' fråga' : ' frågor'; ?>
    <li class='tag-list'>
    <a href='<?=$this->url->create('question/list/'.$tag['slug'])?>'>
    <div class='tag'>
        <span class='tag-label'><?=$tag['name']?></span>
        <p> <?=$tag['questions'].$questions?></p>
    </div>
    </a>
    </li>
    
<?php endforeach; ?>
<?php endif; ?>
</ol>
