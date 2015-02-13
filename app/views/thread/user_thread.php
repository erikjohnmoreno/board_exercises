<div class="span12" style="font-size: 30px; margin: 30px"><strong><?php echo $session_firstname ?>'s threads</strong></div>

<form class="span6">
<ul class="nav">
    <?php foreach ($threads as $v):  ?>
        <li class="well">
        <div class="span5">
            <a href="<?php html_encode(url('comment/view',array('thread_id' => $v->id))) ?>"><b><?php html_encode($v->title) ?></b></a>        
            <br/><i><?php getTimeElapsed($v->created) ?></i>
        </div>
        <?php if ($v->userid == $session_id): ?>
            <a href="<?php html_encode(url('thread/delete', array('thread_id' =>$v->id)))?>" 
               onclick="return confirm('Are you sure you want to delete this thread'?)"><i class="icon-trash"></i></a>
        <?php endif ?>
        </li>
    <?php endforeach ?>
</ul>
</form>
<div class="pagination span12">
    <?php if ($pagination->current > 1): ?>
        &nbsp; <a class="btn btn-primary btn-mini" href="?page=<?php html_encode($pagination->prev)?>">Previous</a> 
    <?php endif ?>
    <?php echo $page_links ?>
    <?php if(!$pagination->is_last_page): ?>
        <a class="btn btn-primary btn-mini" href="?page=<?php html_encode($pagination->next)?>">Next</a>
    <?php endif ?>
</div>
