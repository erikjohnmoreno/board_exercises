<?php if ($user->hasError()): ?>
<div class="alert alert-block">
    <h4 class="alert-heading">FAILED!</h4>

    <?php if (!empty($user->validation_errors['old_password']['match_check'])): ?>
        <div><em>old password </em> did not match
        </div>
    <?php endif ?>
<?php endif ?>

<center>
<form class="well span4" method="post" action="<?php //html_encode(url('thread/index')) ?>">
    <div class="container">
        <div class="row">
            <div class="span4">
                <div>
                <h4>Update Information</h4>
                <input class="span4" type="password" name="old_password" class="form-control input-sm chat-input" placeholder="old password" />
                <input class="span4" type="password" id="userPassword" name="new_password" class="form-control input-sm chat-input" placeholder="new password" />
                <input type="hidden" name="page_next" value="update_info_next">
                <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-block">
                <a href="<?php html_encode(url('thread/index'))?>"> back</a>
                </div>
            
            </div>
        </div>
    </div>
</form>
</center>


