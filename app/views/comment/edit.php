<h2>Edit</h2>

<form class="well" method="post" action="">

    <label>Comment</label>
    <textarea name="body"> <?php html_encode(Param::get('body')) ?></textarea>
    <br/>
    <input type="hidden" name="thread_id" value="<?php html_encode($thread->id) ?>">
    <input type="hidden" name="page_next" value="edit_end">
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="<?php html_encode(url('thread/index'))?>"> Cancel</a>
</form>

