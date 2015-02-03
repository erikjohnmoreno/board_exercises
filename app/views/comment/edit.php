<h2>Edit</h2>

<form class="well" method="post" action="">
<?php foreach ($comments as $key):?>	
    <label>Comment</label>
    <textarea name="body"><?php echo $key->body; html_encode(Param::get('body')) ?></textarea>
    <br/>
    <input type="hidden" name="page_next" value="edit_end">
    <button type="submit" class="btn btn-primary">Done editing</button>
    <a href="<?php html_encode(url('comment/view',array('thread_id' => $key->thread_id)))?>"> Cancel</a>
<?php endforeach ?>
</form>

