<h2>Edit</h2>

<?php if ($comment->hasError()): ?>
<div class="alert alert-block">
<h4 class="alert-heading">Validation error! </h4>
    <?php if (!empty($comment->validation_errors['body']['length'])): ?>
        <div> <em> Your comment</em> must be between
        <?php html_encode($comment->validation['body']['length'][1]) ?> and 
        <?php html_encode($comment->validation['body']['length'][2]) ?> characters in length.
    <?php endif ?>
</div>
<?php endif ?>

<form class="well span6" method="post" action="">
<?php foreach ($comments as $key):?>
    <label>Comment</label>
    <textarea class="span6" style="resize:none" name="body"><?php echo $key->body; html_encode(Param::get('body')) ?></textarea>
    <br/>
    <input type="hidden" name="page_next" value="edit_end">
    <button type="submit" name="edit" class="btn btn-primary">Done editing</button>
    <a href="<?php html_encode(url('comment/view',array('thread_id' => $key->thread_id)))?>"> Cancel</a>
<?php endforeach ?>
</form>

