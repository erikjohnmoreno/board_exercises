
<?php if (isset($_SESSION['id'])): ?>

<h1>My threads</h1>
<ul>
	<?php foreach ($threads as $v):  ?>
		<li>
			<a href="<?php html_encode(url('comment/view',array('thread_id' => $v->id))) ?>"><?php html_encode($v->title) ?></a>
		</li>
	<?php endforeach ?>
</ul>
<?php endif ?>

<br/>
<a class="btn btn-large btn-primary" href="<?php html_encode(url('thread/create')) ?>">Create</a>
<br/><br/>
<a class="btn btn-large btn-primary" href="<?php html_encode(url('user/logout')) ?>">Logout</a>
<a href="<?php html_encode(url('thread/index')) ?>"> See all threads</a>

<?php if (!isset($_SESSION['id'])) {
		header("Location: user/login");
} ?>


