<?php if (!$user->login_flag): ?>
<div class="alert alert-block">
    <h4 class="alert-heading">Hey What You doin Playah? Login Failed!</h4>
</div>
<?php endif ?>
<body style="" >
<center>
<form class="well span4" method="post" action="">
    <div class="container">
        <div class="row">
            <div class="span4">
                <div class="form-login">
                    <h4>WHAT's UP DUDE?</h4>
                    <input class="span4" type="text" id="userName" name="username" class="form-control input-sm chat-input" placeholder="username" />
                    <input class="span4" type="password" id="userPassword" name="password" class="form-control input-sm chat-input" placeholder="password" />
                    <input type="hidden" name="page_next" value="login_next">
                    </br>
                    <div class="wrapper">
                        <span class="group-btn">
                            <button class="btn btn-primary btn-block" >login </button>
                            <a href="<?php html_encode(url('user/register'))?>">Register</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</center>
</body>


