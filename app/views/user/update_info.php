<?php if ($user->hasError()): ?>
    <div class="alert alert-block">
        <h4 class="alert-heading">FAILED!</h4>
        <?php if (!empty($user->validation_errors['old_password']['match_check'])): ?>
            <div><em>old password </em> did not match
            </div>
        <?php endif ?>

        <?php if (!empty($user->validation_errors['new_password']['confirm_retyped_password'])): ?>
            <div><em>new password</em> did not match</div>           
        <?php endif ?>
    </div>
<?php endif ?>

<center>
    <form class="well span4" method="post">
        <div class="container">
            <div class="row">
                <div class="span4">
                    <h4>Change Password</h4>
                    <input class="span4" type="password" name="old_password" class="form-control input-sm chat-input" placeholder="old password" />
                    <input class="span4" type="password" id="userPassword" name="new_password" class="form-control input-sm chat-input" placeholder="new password" />
                    <input class="span4" type="password" name="retype_newpassword" placeholder="retype new password">
                    <input type="hidden" name="page_next" value="update_info_next">
                    <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-block" onclick="return confirm('Are you sure you want to change your password?')">
                    <a href="<?php html_encode(url('user/user_profile'))?>"> back</a>
                </div>
            </div>
        </div>
    </form>
</center>


