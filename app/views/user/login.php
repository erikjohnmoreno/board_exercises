

<?php

 if (!$user->login_flag): ?>
<div class="alert alert-block">
    <h4 class="alert-heading">Hey What You doin Playah? Login Failed!</h4>
</div>
<?php endif ?>


<form class="well" method="post" action="<?php //html_encode(url('user/login')) ?>">
<div class="container">
    <div class="row">
        <div class="col-md-offset-5 col-md-3">
            <div class="form-login">
            <h4>WHAT's UP DUDE?</h4>
            <input type="text" id="userName" name="username" class="form-control input-sm chat-input" placeholder="username" />
            </br>
            <input type="password" id="userPassword" name="password" class="form-control input-sm chat-input" placeholder="password" />
            <input type="hidden" name="page_next" value="login_next">
            </br>
            <div class="wrapper">
            <span class="group-btn">     
                <button class="btn btn-primary btn-md" >login </button>
                <a class="btn btn-primary" href="<?php html_encode(url('user/register'))?>">Register</a>
            </span>
            </div>
            </div>
        
        </div>
    </div>
</div>
</form>