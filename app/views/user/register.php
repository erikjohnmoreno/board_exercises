<h1>Register</h1>

<?php if ($user->hasError()): ?>
<div class="alert alert-block">
	<h4 class="alert-heading">FAILED!</h4>

    <?php if (!empty($user->validation_errors['username']['length'])): ?>
    	<div><em>Username </em>must be between
    	<?php html_encode($user->validation['username']['length'][1]) ?> and
    	<?php html_encode($user->validation['username']['length'][2]) ?> characters in length.
      	</div>
    <?php endif ?>

    <?php if (!empty($user->validation_errors['password']['length'])): ?>                 
  		<div><em>Password </em> must be between
    	 <?php html_encode($user->validation['password']['length'][1]) ?> and
    	 <?php html_encode($user->validation['password']['length'][2]) ?> characters in length.
   		 </div>
	<?php endif ?>

	<?php if (!empty($user->validation_errors['username']['duplicate'])): ?>
		<div><em>Username </em> already exists</div>
	<?php endif ?>



</div>
                
<?php endif ?>

<form class="well" method="post" action="<?php html_encode(url('')) ?>">
<label>Username</label>
<input type="text" class="span2" name="username" value="<?php html_encode(Param::get('username')) ?>">
<label>Password</label>
<input type="password" class="span2" name="password" value="<?php html_encode(Param::get('password')) ?>">
<br />
<input type="hidden" name="page_next" value="register_end">
<button type="submit" class="btn btn-primary">Submit</button>     
<a href="<?php html_encode(url('user/login'))?>">Go back to login</a>           
</form>