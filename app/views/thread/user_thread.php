  
<h1 style="font-size: 55px">My threads</h1>
<ul class="nav">
    <a class="offset8" style="font-size: 50px" href=""><?php echo $session_firstname?></a>
    <?php foreach ($threads as $v):  ?>
        <li class="well">
            <a href="<?php html_encode(url('comment/view',array('thread_id' => $v->id))) ?>"><b><?php html_encode($v->title) ?></b></a>        
        &nbsp;&nbsp;<i><?php getTimeElapsed($v->created) ?></i>
        <?php if ($v->userid == $session_id): ?>
            <a class="offset9" href="<?php html_encode(url('thread/delete', array('thread_id' =>$v->id)))?>" onclick="return confirm('Are you sure you want to delete this thread'?)">delete this thread</a>
        <?php endif ?>
        </li>
    <?php endforeach ?>
    
</ul>
    <div class="pagination">
        <?php if ($pagination->current > 1): ?>
            &nbsp; <a class="btn btn-primary btn-mini" href="?page=<?php html_encode($pagination->prev)?>">Previous</a> 
        <?php endif ?>

        <?php echo $page_links ?>

        <?php if(!$pagination->is_last_page): ?>
            <a class="btn btn-primary btn-mini" href="?page=<?php html_encode($pagination->next)?>">Next</a>
        <?php endif ?>
    </div>

<br/>

<a class="btn btn-large btn-primary" href="<?php html_encode(url('thread/index')) ?>"> See all threads</a>
<a class="btn btn-large btn-default" href="<?php html_encode(url('user/logout')) ?>">Logout</a>



