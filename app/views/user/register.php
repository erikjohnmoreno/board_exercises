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

        <?php if (!empty($user->validation_errors['firstname']['length'])): ?>
          <div><em>first name </em> must be between
            <?php html_encode($user->validation['firstname']['length'][1]) ?> and
            <?php html_encode($user->validation['firstname']['length'][2]) ?> characters in length.
          </div>
        <?php endif ?>

        <?php if (!empty($user->validation_errors['lastname']['length'])): ?>
          <div><em>last name </em> must be between
            <?php html_encode($user->validation['lastname']['length'][1]) ?> and
            <?php html_encode($user->validation['lastname']['length'][2]) ?> characters in length.
          </div>
        <?php endif ?>

        <?php if (!empty($user->validation_errors['username']['duplicate'])): ?>
          <div><em>Username/E-mail </em> already exists</div>
        <?php endif ?>
        <?php if (!empty($user->validation_errors['email']['email_check'])): ?>
          <div><em>invalid email</em></div>
        <?php endif ?>
    </div>
<?php endif ?>

<form class="well span4" method="post">
    <label>Username</label>
    <input type="text" class="span4" name="username" placeholder="username" value="<?php html_encode(Param::get('username')) ?>" required>
    <label>Password</label>
    <input type="password" class="span4" name="password" placeholder="password" value="<?php html_encode(Param::get('password')) ?>" required>
    <label>First Name</label>
    <input type="text" class="span4" name="firstname" placeholder="First Name" value="<?php html_encode(Param::get('firstname')) ?>" required>
    <label>Last Name</label>
    <input type="text" class="span4" name="lastname" placeholder="Last Name" value="<?php html_encode(Param::get('lastname')) ?>" required>
    <label>E-mail</label>
    <input type="email" class="span4" name="email" placeholder="email" value="<?php html_encode(Param::get('email'))?>" required>
    <br />
    <input type="hidden" name="page_next" value="register_end">
    <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to proceed?')">Submit</button>
    <a href="<?php html_encode(url('user/login'))?>">Go back to login</a>
</form>