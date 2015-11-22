<div class='comment-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$this->url->create($redirect)?>">
        <input type=hidden name="key" value="<?=$key?>"> 
        <fieldset>
        <legend>Skriv en kommentar</legend>
        <p><label>Kommentar:<br/><textarea name='content'><?=$content?></textarea></label></p>
        <p><label>Namn:<br/><input type='text' name='name' value='<?=$name?>'/></label></p>
        <p><label>Hemsida:<br/><input type='url' placeholder='http://www.exempel.se' name='web' value='<?=$web?>'/></label></p>
        <p><label>E-post:<br/><input type='email' placeholder='ditt.namn@exempel.se' name='mail' value='<?=$mail?>'/></label></p>
        <p class=buttons>
            <input type='submit' name='doCreate' value='Kommentera' onClick="this.form.action = '<?=$this->url->create('comment/add')?>'"/>
            <input type='reset' value='Rensa'/>
            <input type='submit' name='doRemoveAll' value='Ta bort alla' onClick="this.form.action = '<?=$this->url->create('comment/remove-all')?>'"/>
        </p>
        <output><?=$output?></output>
        </fieldset>
    </form>
</div>
