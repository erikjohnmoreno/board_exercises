<h1>All threads</h1>
<ul>
<?php if (isset($_SESSION['id'])): ?>
	

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
<a class="btn btn-large btn-primary" href="<?php html_encode(url('user/logout')) ?>">Logout</a>
<?php endif ?>

<?php if (!isset($_SESSION['id'])) {
	header("Location: user/login");
} ?>
