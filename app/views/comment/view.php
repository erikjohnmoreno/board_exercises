<div class="span12"><h3>
    <?php html_encode($thread->title) ?> 
    <!-- <a class="btn btn-large btn-primary" href="<?php html_encode(url('comment/top_comments'))?>">View Top Comments</a>
    <a class="btn btn-large btn-primary" href="<?php html_encode(url('thread/index'))?>"> Go back to thread</a> -->    
</h3></div>

<form class="well span6">
    <?php foreach ($comments as $k => $v): ?>
        <?php foreach ($users as $key => $value): ?>
            <?php if ($value->id == $v->userid): ?>
                <div class="comment">
                    <div class="meta">
                        <u style="font-size: 16px"><a href="<?php html_encode(url('user/others_profile', array('userid' => $v->userid))) ?>"><?php html_encode($value->firstname) ?></a></u>&nbsp;<i>post a comment <?php getTimeElapsed($v->created) ?></i>
                    </div>
                    <input type="hidden" name="comment_id" value="<?php html_encode($v->id)?>">
                    <div style="font-size: 12px; word-wrap: break-word">
                        <b style="font-size: 14px"><?php echo readable_text($v->body) ?></b><br/> 
                        <i><?php if ($v->likes > 0) echo $v->likes ." user liked this comment"?></i> <br/>&nbsp;&nbsp;&nbsp;


                        <?php if (!$comment->isliked($v->id, $session_id)): ?>    
                            <a href="<?php html_encode(url('comment/like_comment', array('comment_id' => $v->id,'thread_id' => $v->thread_id)))?>">like</a>&nbsp;&nbsp;

                        <?php else: ?>
                            <a href="<?php html_encode(url('comment/unlike_comment', array('comment_id' => $v->id)))?>">unlike</i></a>&nbsp;&nbsp;
                        <?php endif ?>

                        <?php if ($v->userid == $session_id): ?>
                            <a href="<?php html_encode(url('comment/edit',array('comment_id' => $v->id)))?>">
                                <i class="icon-edit"></i></a>&nbsp;&nbsp;
                            <a href="<?php html_encode(url('comment/delete',array('comment_id' => $v->id)))?>" 
                                onclick="return confirm('Are you sure you want to delete this comment?')">
                                <i class="icon-trash"></i></a>
                        <?php endif ?>
                    </div>
                    <br/>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    <?php endforeach ?>

    <?php if ($thread->userid == $session_id): ?>
        <a class="offset3" href="<?php html_encode(url('thread/delete', array('thread_id' =>$thread->id)))?>" onclick="return confirm('Are you sure you want to delete this whole thread?')" >delete this whole thread</a>
    <?php endif ?>
</form>
<form class="well span4" method="post" action="<?php html_encode(url('comment/write')) ?>">
        <label>Comment</label>
        <textarea class="span4" style="resize:none" name="body"><?php html_encode(Param::get('body')) ?></textarea>
        <br/>
        <input type="hidden" name="thread_id" value="<?php html_encode($thread->id) ?>">
        <input type="hidden" name="page_next" value="write_end">
        <button type="submit" class="btn btn-primary">Submit</button>      
</form>
    <div class="pagination span12">
        <?php if ($pagination->current > 1): ?>
            &nbsp; <a class="btn btn-primary btn-mini" href="?page=<?php html_encode($pagination->prev)?>&thread_id=<?php html_encode($thread->id)?>">Previous</a> 
        <?php endif ?>
        <?php echo $page_links ?>
        <?php if (!$pagination->is_last_page): ?>
            <a class="btn btn-primary btn-mini" href="?page=<?php html_encode($pagination->next) ?>&thread_id=<?php html_encode($thread->id)?>">Next</a>
        <?php endif ?>
    </div>
<hr>

    
