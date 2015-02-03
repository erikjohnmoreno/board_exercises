<h2><?php html_encode($thread->title) ?></h2>
<p class="alert alert-success">
    You succesfully wrote this comment.
</p>
<a href="<?php html_encode(url('comment/view',array('thread_id' =>$thread->id))) ?>">
&larr; Back to thread
</a>