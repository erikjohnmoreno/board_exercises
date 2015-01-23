<h2><?php html_encode($thread->title) ?></h2>

<?php if ($comment->hasError()): ?>
<div class="alert alert-block">

<h4 class="alert-heading">Validation error! </h4>

	<?php if (!empty($comment->validation_errors['username']['length'])): ?>
		<div> <em>Your name</em> must be between
			<?php html_encode($comment->validation['username']['length'][0]) ?> and 
			<?php html_encode($comment->validation['username']['length'][2]) ?> characters in length.
		</div>
	<?php endif ?> 

</div>
<?php endif ?>

<form class="well" method="post" action="<?php html_encode(url('thread/write')) ?>">
<label>Your name</label>
<input type="text" class="span2" name="username" value="<?php html_encode(Param::get('username')) ?>">
<label>Comment</label>
<textarea name="body"><?php html_encode(Param::get('body')) ?></textarea>
<br/>
<input type="hidden" name="thread_id" value="<?php html_encode($thread->id) ?>">
<input type="hidden" name="page_next" value="write_end">
<button type="submit" class="btn btn-primary">Submit</button>

</form>

