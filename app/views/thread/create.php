<h1>Create a thread</h1>

<?php if ($thread->hasError() || $comment->hasError()): ?>
    <div class="alert alert-block">
        <h4 class="alert-heading">Validation error!</h4>

        <?php if (!empty($thread->validation_errors['title']['length'])): ?>
            <div><em>Title</em> must be between
            <?php html_encode($thread->validation['title']['length'][1]) ?> and
             <?php html_encode($thread->validation['title']['length'][2]) ?> characters in length.
            </div>
        <?php endif ?>

          <?php if (!empty($comment->validation_errors['body']['length'])): ?>
              <div><em>Comment</em> must be between
             <?php html_encode($comment->validation['body']['length'][1]) ?> and
             <?php html_encode($comment->validation['body']['length'][2]) ?> characters in length.
                </div>
        <?php endif ?>

    </div>
<?php endif ?>

<form style="box-shadow: black 0.3em 0.3em 0.3em"class="well span6" method="post">
    <label>Title</label>
    <input type="text" class="span2" name="title" value="<?php html_encode(Param::get('title')) ?>">
    <label>Comment</label>
    <textarea class="span6" style="resize: none" name="body"><?php html_encode(Param::get('body')) ?></textarea>
    <br />
    <input type="hidden" name="page_next" value="create_end">
    <button type="submit" class="btn btn-primary">Submit</button>  
</form> 
