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

  <body style="background: url('/bootstrap/img/notice_board.jpg')">

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="/">The Board</a>
        </div>
      </div>
    </div>

    <div class="container">

      <?php echo $_content_ ?>

    </div>

    <script>
    console.log(<?php html_encode(round(microtime(true) - TIME_START, 3)) ?> + 'sec');
    </script>

  </body>
</html>
