
<div style="font-size: 55px; margin: 35px; color: #003366"><strong>All threads</strong></div>
<!-- <form class="pull-right well span5"> 
    <a class="" style="font-size: 30px" href="<?php html_encode(url('user/user_profile'))?>"><?php echo $session_firstname ?>'s Profile</a>
    <a style="color: #000000" class="btn btn-large btn-default" href="<?php html_encode(url('user/logout')) ?>">Logout</a>
</form> -->
<!-- <form class="span12">
    <a class="btn btn-large btn-primary" href="<?php html_encode(url('thread/user_thread'))?>"> View My threads</a>
    <a class="btn btn-large btn-primary" href="<?php html_encode(url('thread/top_threads'))?>">View Top Threads</a>
    <a class="btn btn-large btn-primary" href="<?php html_encode(url('comment/top_comments'))?>">View Top Comments</a>
    <a class="btn btn-large btn-primary" href="<?php html_encode(url('user/users_list')) ?>">All Users</a>
    <a class="btn btn-large btn-primary" href="<?php html_encode(url('thread/create')) ?>">Create Thread</a>
</form> -->
<form class="span6">
    <ul class="nav ">
        <?php foreach ($threads as $v):  ?>
            <?php foreach ($users as $key => $value): ?>
                <?php if ($value->id == $v->userid): ?>
                    <li class="well">
                    <div class="span5">
                        <a href="<?php html_encode(url('comment/view',array('thread_id' => $v->id))) ?>"><b><?php html_encode($v->title)?></b></a>
                        <br/><i>created by: <?php echo "$value->firstname "; getTimeElapsed($v->created) ?></i>
                    </div>
                        <?php if ($v->userid == $session_id): ?>
                            <a class="" href="<?php html_encode(url('thread/delete', array('thread_id' =>$v->id)))?>" onclick="return confirm('Are you sure you want to delete this thread?')" ><i class="icon-trash"></i></a>
                        <?php endif ?>
                    </li>
                    <?php endif ?>
            <?php endforeach ?>
        <?php endforeach ?>
    </ul>
</form>

<div class="pagination span12">
    <?php if($pagination->current > 1): ?>
        &nbsp;<a class="btn btn-primary btn-mini" href="?page=<?php html_encode($pagination->prev) ?>"> Previous</a>
    <?php endif ?>
    <?php echo $page_links ?>
    <?php if(!$pagination->is_last_page): ?>
        <a class="btn btn-primary btn-mini" href="?page=<?php html_encode($pagination->next)?>">Next</a>
    <?php endif ?>
</div>
