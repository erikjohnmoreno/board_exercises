

	
<h1>All threads</h1>
<ul>
	<?php foreach ($threads as $v):  ?>
		<li>
			<a href="<?php html_encode(url('comment/view',array('thread_id' => $v->id))) ?>"><?php html_encode($v->title) ?></a>
		</li>
	<?php endforeach ?>

	<div class="pagination">
		<?php if ($pagination->current == 1) {
		 	echo "this is one haha ";
		} ?>
		<?php if($pagination->current > 1): ?>
			&nbsp;<a class="btn btn-primary" href="?page=<?php html_encode($pagination->prev) ?>"> Previous</a>
		<?php endif ?>

	<!-- display links -->
	<?php foreach ($divided_page as $chunk ): ?>
			<a class="btn btn-primary" href=""> <?php echo $i+1 ?></a>
	<?php $i++; endforeach ?>
		
		

		<!--&nbsp; <?php //foreach ($divided_page as $item): ?>
			<a class="btn btn-primary" href="<?php// echo $item['id']?>"><?php //echo $item['id'] ?></a> &nbsp;&nbsp;
		<?php //endforeach ?>-->

		<?php if(!$pagination->is_last_page): ?>
			<a class="btn btn-primary" href="?page=<?php echo $pagination->next?>">Next</a>
		<?php else: ?>
			Next
		<?php endif ?>	
	</div>
</ul>


<br/>
<br/><br/>
<a class="btn btn-large btn-primary" href="<?php html_encode(url('user/logout')) ?>">Logout</a>
<a href="<?php html_encode(url('thread/view_user_thread'))?>"> View My threads</a>



