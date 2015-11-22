<div class='comment-form'> 
    <form method=post> 
        <input type=hidden name="redirect" value="<?=$this->url->create($redirect)?>"> 
        <input type=hidden name="key" value="<?=$key ?>"> 
        <fieldset> 
        <legend>Redigera en kommentar</legend> 
        <p><label>Kommentar:<br/><textarea name='content'><?=$content?></textarea></label></p> 
        <p><label>Namn:<br/><input type='text' name='name' value='<?=$name?>'/></label></p> 
        <p><label>Hemsida:<br/><input type='text' name='web' value='<?=$web?>'/></label></p> 
        <p><label>E-post:<br/><input type='text' name='mail' value='<?=$mail?>'/></label></p> 
        <p class=buttons> 
            <input type='submit' name='doSave' value='Spara' onClick="this.form.action = '<?=$this->url->create('comment/save') .'/' . $id?>'" /> 
            <input type='reset' value='Rensa'/> 
            <input type='submit' name='doCancel' value='Avbryt' onClick="this.form.action = '<?=$this->url->create($redirect)?>'"/> 
        </p> 
        </fieldset> 
    </form> 
</div> 
