<?php if (!$user->login_flag): ?>
<div class="alert alert-block">
    <h4 class="alert-heading">Hey What You doin Playah? Login Failed!</h4>
</div>
<?php endif ?>


<body style="background: url('/bootstrap/img/board.jpg'); background-repeat: no-repeat;">
<center>
<div style="padding-top: 200px; padding-left: 200px; overflow: hidden">
<form class="span6" method="post" action="">
    <div class="container">
        <div class="row">
            <div class="span6">
                <div class="form-login">
                    <h4>WHAT's UP DUDE?</h4>
                    <input class="span6" type="text" id="userName" name="username" class="form-control input-sm chat-input" placeholder="username" />
                    <input class="span6" type="password" id="userPassword" name="password" class="form-control input-sm chat-input" placeholder="password" />
                    <input type="hidden" name="page_next" value="login_next">
                    </br>
                    <div class="wrapper">
                        <span class="group-btn">
                            <button class="btn btn-primary btn-block" >login </button>
                            <a style="color: #003366"href="<?php html_encode(url('user/register'))?>">Register</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
</center>
</body>


