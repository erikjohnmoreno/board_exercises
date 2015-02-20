
<div style="text-shadow: 0.1em 0.1em 0.03em #000000; color: #FFFFFF; font-size: 55px; margin: 35px; "><strong>All threads</strong></div>
<form  class="span6">
    <ul class="nav ">
        <?php foreach ($threads as $v):  ?>
            <?php foreach ($users as $key => $value): ?>
                <?php if ($value->id == $v->userid): ?>
                    <li style="box-shadow: black 0.3em 0.3em 0.3em" class="well">
                    <div class="span5">
                        <a href="<?php html_encode(url('comment/view',array('thread_id' => $v->id))) ?>"><b><?php html_encode($v->title)?></b></a>
                        <br/><i><a href="<?php html_encode(url('user/others_profile', array('userid' => $v->userid))) ?>"><i class="icon-user"></i><?php echo "$value->firstname "?></a> <?php getTimeElapsed($v->created) ?></i>
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

    <?php for ($i = 0; $i < count($page_links) ; $i++): ?>
        <?php if ($page_links[$i] == $pagination->current): ?>
            <a class="btn btn-default btn-mini disabled" href=""><?php echo $page_links[$i] ?></a>
        <?php else: ?>
            <a class="btn btn-primary btn-mini" href="?page=<?php html_encode($page_links[$i]) ?>"><?php echo $page_links[$i] ?></a>
        <?php endif ?>
    <?php endfor ?> 

    <?php if(!$pagination->is_last_page): ?>
        <a class="btn btn-primary btn-mini" href="?page=<?php html_encode($pagination->next)?>">Next</a>
    <?php endif ?>
</div>
