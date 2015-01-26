<h1>All threads</h1>
<ul>
	<?php foreach ($threads as $v):  ?>
	<li>
	<a href="<?php html_encode(url('thread/view',array('thread_id' => $v->id))) ?>">
	<?php html_encode($v->title) ?></a>
	
	</li>
	<?php endforeach ?>
</ul>
<br/>
<a class="btn btn-large btn-primary" href="<?php html_encode(url('thread/create')) ?>">Create</a>
<br/><br/>
