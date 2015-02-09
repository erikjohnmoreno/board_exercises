<h1><?php html_encode($thread->title) ?></h1>
<?php foreach ($comments as $k => $v): ?>
    <div class="comment">
        <div class="meta">
            <b><?php html_encode($v->username) ?></b> &nbsp;<i><?php getTimeElapsed($v->created) ?></i>
        </div>
        <input type="hidden" name="comment_id" value="<?php html_encode($v->id)?>">
        <div>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo readable_text($v->body) ?>&nbsp;&nbsp;
        <a href="<?php html_encode(url('comment/like_comment', array('comment_id' => $v->id)))?>">like</a>
        <?php if ($v->userid == $session_id): ?>
            <a href="<?php html_encode(url('comment/edit',array('comment_id' => $v->id)))?>">edit</a>
            <a href="<?php html_encode(url('comment/delete',array('comment_id' => $v->id)))?>" onclick="return confirm('Are you sure you want to delete this comment?')">delete</a>

        <?php endif ?>
        </div>
        <br/>
    </div>
<?php endforeach ?>

    <div class="pagination">
        <?php if ($pagination->current > 1): ?>
            &nbsp; <a class="btn btn-primary btn-mini" href="?page=<?php html_encode($pagination->prev)?>&thread_id=<?php html_encode($thread->id)?>">Previous</a> 
        <?php endif ?>

        <?php echo $page_links ?>

        <?php if (!$pagination->is_last_page): ?>
            <a class="btn btn-primary btn-mini" href="?page=<?php html_encode($pagination->next) ?>&thread_id=<?php html_encode($thread->id)?>">Next</a>
        <?php endif ?>
    </div>
<hr>
    <form class = "well" method="post" action="<?php html_encode(url('comment/write')) ?>">
        <label>Comment</label>
        <textarea name="body"><?php html_encode(Param::get('body')) ?></textarea>
        <br/>
        <input type="hidden" name="thread_id" value="<?php html_encode($thread->id) ?>">
        <input type="hidden" name="page_next" value="write_end">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="<?php html_encode(url('thread/index'))?>"> Go back to thread</a>
    </form>
