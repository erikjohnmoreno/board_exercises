<?php 

 class Comment extends AppModel
 {
    const MIN_LENGTH = 1;
    const MAX_LENGTH_USERNAME = 16;
    const MAX_LENGTH_COMMENT = 200;

     public $validation = array(
             'username' => array(
                'length' => array(
                     'validate_between', self::MIN_LENGTH, self::MAX_LENGTH_USERNAME,
                     ),
                 ),

             'body' => array(
                'length' => array(
                     'validate_between',self::MIN_LENGTH, self::MAX_LENGTH_COMMENT,
                     ),
                 ),
             );

    //retrieve comments of a certain thread from database
    public function getComments($thread_id)
    {
        $comments = array();

        $db = DB::conn();
        $rows = $db->rows('SELECT * FROM user 
                            INNER JOIN comment 
                            ON user.id = comment.userid 
                            WHERE comment.thread_id = ? 
                            ORDER BY comment.created ASC',
                            array($thread_id));
        /*$rows = $db->rows('SELECT * FROM user a, comment b
                           WHERE a.id = b.userid 
                           AND b.thread_id = ?
                           ORDER BY b.created ASC',
                           array($thread_id));*/

        foreach ($rows as $row) {
            $comments[] = new self($row);
        }

        return $comments;
    }

    //get all comments of a certain comment_id
    public function getAllComments($comment_id)
    {
        $comments = array();

        $db = DB::conn();

        $rows = $db->rows('SELECT * FROM comment 
                            WHERE id = ?',
                            array($comment_id));

        foreach ($rows as $row) {
            $comments[] = new self($row);
        }

        return $comments;
    }

    //inserting a comment to a certain thread_id to database
    public function write(Comment $comment, $thread_id, $session_id)
    {
        $thread = new Thread();
        if (!$comment->validate()) {
            throw new ValidationException('invalid comment');
        }
        try {
            $db = DB::conn();
            $db->insert('comment', array('thread_id' => $thread_id,
                                         'body' => $comment->body,
                                         'userid' => $session_id));
            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
        }    
    }

    public function edit()
    {
        if (!$this->validate()) {
            throw new ValidationException('invalid comment');
        }
        $current_time = date('Y-m-d H:i:s'); 
        try {
            $db = DB::conn();
            $db->begin();
            $db->update('comment', 
                         array('body' => $this->body, 
                               'created' => $current_time), 
                         array('id' => $this->comment_id));
            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
        }
    }

    public function delete($comment_id)
    {
        try {
            $db = DB::conn();
            $db->begin();
            $db->query('DELETE FROM comment WHERE id = ?', 
                        array($comment_id));
            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
        }
    }
                    //comment id of the comment   //user that liked the comment
    public function likeComment($user_id)
    {
        try {
            $db = DB::conn();
            $db->begin();
            $db->insert('liked', array('comment_id' => $this->comment_id,
                                       'user_id' => $user_id));
            $db->commit();
        } catch (Exception $e) {
            $db->rollback();        
        }
    }

    public function getCommentCount()
    {
        $comment_count = array();
        $db= DB::conn();
        $rows = $db->rows('SELECT comment_id, count(user_id) FROM liked 
                           GROUP BY comment_id');

        foreach ($rows as $row) {
            $comment_count[] = new self($row);
        }

        return $comment_count;
    }
    
 } 
