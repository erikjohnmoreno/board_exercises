<h1><?php html_encode($thread->title) ?></h1>
<?php foreach ($comments as $k => $v): ?>
	<div class="comment">
	<div class="meta">
		<?php html_encode($k + 1) ?>: <?php html_encode($v->username) ?> <?php html_encode($v->created) ?>
	</div>

	<div><?php html_encode($v->body) ?></div>
	<div><?php echo readable_text($v->body) ?></div>
	</div>

	<?php endforeach ?>

<hr>
	<form class = "well" method="post" action="<?php html_encode(url('thread/write')) ?>">
		<label>Your name</label>
		<input type="text" class="span2" name="username" value="<?php html_encode(Param::get('username')) ?>">
		<label>Comment</label>
		<textarea name="body"><?php html_encode(Param::get('body')) ?></textarea>
		<br/>
		<input type="hidden" name="thread_id" value="<?php html_encode($thread->id) ?>">
		<input type="hidden" name="page_next" value="write_end">
		<button type="submit" class="btn btn-primary">Submit</button>

	</form>