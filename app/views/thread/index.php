
<?php if (isset($_SESSION['id'])): ?>
<h1>All threads</h1>
<ul class="nav">
    
    <?php foreach ($threads as $v):  ?>
        <li class="well">
            <a href="<?php html_encode(url('comment/view',array('thread_id' => $v->id))) ?>"><b><?php html_encode($v->title)?></b></a>                   
        &nbsp;&nbsp;<i><?php getTimeElapsed($v->created) ?></i>
        </li>
    <?php endforeach ?>
</ul>
    <div class="pagination">
        
        <?php if($pagination->current > 1): ?>
            &nbsp;<a class="btn btn-primary btn-mini" href="?page=<?php html_encode($pagination->prev) ?>"> Previous</a>
        <?php endif ?>

        <?php echo $page_links ?>

        <?php if(!$pagination->is_last_page): ?>
            <a class="btn btn-primary btn-mini" href="?page=<?php  html_encode($pagination->next)?>">Next</a>            
        <?php endif ?>    
    </div>

<br/><br/><br/>
    <a class="btn btn-large btn-primary" href="<?php html_encode(url('thread/user_thread'))?>"> View My threads</a>
    <a class="btn btn-large btn-primary" href="<?php html_encode(url('user/update_info'))?>">Update Information</a>
    <a class="btn btn-large btn-primary" href="<?php html_encode(url('user/logout')) ?>">Logout</a>

<?php else: header('Location: user/login') ?>
<?php endif ?>

