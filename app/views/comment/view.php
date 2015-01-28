<h1><?php html_encode($thread->title) ?></h1>

<?php foreach ($comments as $k => $v): ?>
	<div class="comment">
	<div class="meta">
		<?php html_encode($k + 1) ?>: <?php html_encode($v->username) ?> <?php html_encode($v->created) ?>
	</div>

	<!--<div><?//php html_encode($v->body) ?></div>-->
	<div><?php echo readable_text($v->body) ?></div>
	</div>

	<?php endforeach ?>

	<div class="pagination">
		<?php if ($pagination->current > 1): ?>
			&nbsp; <a class="btn btn-primary" href="?page=<?php html_encode($pagination->prev)?>&thread_id=<?php html_encode($thread->id)?>">Previous</a> 
		<?php endif ?>

		<?php echo $page_links ?>

		<?php if(!$pagination->is_last_page): ?>
			<a class="btn btn-primary" href="?page=<?php html_encode($pagination->next) ?>&thread_id=<?php html_encode($thread->id)?>">Next</a>
		<?php endif ?>
	</div>


<hr>
	<form class = "well" method="post" action="<?php html_encode(url('comment/write')) ?>">
		<!--<label>Your name</label>
		<input type="text" class="span2" name="username" value="<?php// html_encode(Param::get('username')) ?>">-->
		<label>Comment</label>
		<textarea name="body"><?php html_encode(Param::get('body')) ?></textarea>
		<br/>
		<input type="hidden" name="thread_id" value="<?php html_encode($thread->id) ?>">
		<input type="hidden" name="page_next" value="write_end">
		<button type="submit" class="btn btn-primary">Submit</button>
		<a href="<?php html_encode(url('thread/index'))?>"> Go back to thread</a>
	</form>
