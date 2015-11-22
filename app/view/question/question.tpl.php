<?php $controller = isset($controller) ? $controller : 'question'; ?>
<div class='questions'>
<h2>Fråga</h2>

<?php if (is_array($questions)) : ?>
<?php foreach ($questions as $id => $question) : ?>
<?php $id = (is_object($question)) ? $question->id : $id; ?>
<?php $question = (is_object($question)) ? get_object_vars($question) : $question; ?>

<?php
$content = $this->textFilter->doFilter($question['content'], 'shortcode, markdown');
?>

<div class='comment'>
<h4>
<?php if(isset($_SESSION['user']) && $_SESSION['user']->name == $question['name']) : ?>
<a href='<?=$this->url->create($controller .'/edit/'.$id)?>'>#<?=$id?></a>
<?php else : ?>
#<?=$id?> 
<?php endif; ?>
<?=$question['title']?>
</h4>
<div class='comment-content'>
<?=$content?>

<?php 
$tagslugs = explode(",", $question['tagslug']);
$tags = explode(",", $question['tag']);
for($i = 0; $i < count($tags); $i++) {
    echo "<span class='tag-label'><a href='".$this->url->create('question/list/'.$tagslugs[$i])."'>" . $tags[$i] . " </a></span>";
}
?>

</div>
<div class='comment-footer'>
<p><?= "Svar: " . $question['answers'] . " Kommentarer: " . $question['comments']; ?></p>
<p>Skrevs av <a href='<?=$this->url->create('users/id/'.$question['userid'])?>'><?=$question['name']?></a> för 
<?php $elapsedsec = (time()-strtotime($question['timestamp'])); ?>
<?php if (($elapsedsec) < 60): ?>
<?=round($elapsedsec)?> s sedan.
<?php elseif (($elapsedsec/60) < 60): ?>
<?=round($elapsedsec/60)?> minuter sedan.
<?php elseif (($elapsedsec/(60*60)) < 24): ?>
<?=round($elapsedsec/(60*60))?> h sedan.
<?php elseif (($elapsedsec/(60*60*24)) < 7): ?>
<?=round($elapsedsec/(60*60*24))?> dygn sedan.
<?php elseif (($elapsedsec/(60*60*24)) < 30) : ?>
<?=round($elapsedsec/(60*60*24*7))?> veckor sedan.
<?php else : ?>
<?=round($elapsedsec/(60*60*24*30))?> månader sedan.
<?php endif; ?></p>
<img class='gravatar' src='<?=$question['gravatar']?>?s=40' alt='gravatar'>
<?php if (!empty($question['web'])) : ?>
<?php $prefix = preg_match('/^[www]/', $question['web']) ? 'http://' : '';?>
<a href='<?=$prefix.$question['web']?>' target='_blank'>Hemsida</a>
<?php endif; ?>
</div>
</div>

<?php endforeach; ?>

<?php endif; ?>
<?php if (is_string($questions)) : ?>
<p class='comment'><?=$questions?></p>

<?php endif; ?>


</div> 