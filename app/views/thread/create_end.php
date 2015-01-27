<h2><?php html_encode($thread->title) ?></h2>

<p class="alert alert-success">You successfully created</p>

<a href="<?php html_encode(url('comment/view', array('thread_id' =>$thread->id))) ?>">
&larr; Go to thread
</a>