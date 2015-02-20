<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>The Board</title>

    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.css">
    <style>
      body {
        padding-top: 60px;
      }
    </style>
  </head>

  <body style="background: url('/bootstrap/img/notice_board.jpg');">


    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="/">The Board</a>
          <?php if (isset($_SESSION['id'])): ?>
            <div class="offset7">
            <a class="brand" style="font-size: 20px" href="<?php html_encode(url('user/user_profile'))?>"><?php echo $_SESSION['firstname'] ?>'s Profile</a>
            </div>
            <div class="offset10">
            <a style="color: #000000" class="btn btn-large btn-default" href="<?php html_encode(url('user/logout')) ?>">Logout</a>
            </div>
          <?php endif ?>
        </div>
      </div>
    </div>

    <div class="container">
      <?php if (isset($_SESSION['id'])): ?>

        
        <a class="btn btn-large btn-primary" href="<?php html_encode(url('thread/index')) ?>"> See all threads</a>
        <a class="btn btn-large btn-primary" href="<?php html_encode(url('thread/user_thread'))?>">Created threads</a>
        <a class="btn btn-large btn-primary" href="<?php html_encode(url('thread/top_threads'))?>">Top Threads</a>
        <a class="btn btn-large btn-primary" href="<?php html_encode(url('comment/top_comments'))?>">Top Comments</a>
        <a class="btn btn-large btn-primary" href="<?php html_encode(url('user/users_list')) ?>">All Users</a>
        <a class="btn btn-large btn-primary" href="<?php html_encode(url('thread/create')) ?>">Create Thread</a>   
        
       
      <?php endif ?>
     <?php echo $_content_ ?>
   

    
    </div>


    <script>
    console.log(<?php html_encode(round(microtime(true) - TIME_START, 3)) ?> + 'sec');
    </script>

  </body>
</html>
