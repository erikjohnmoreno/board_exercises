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
        public function getComments($threadId)
        {
            $comments = array();

            $db = DB::conn();

            $rows = $db->rows('SELECT * FROM user 
                               INNER JOIN comment 
                               ON user.id = comment.userid 
                               WHERE comment.thread_id = ? 
                               ORDER BY comment.created ASC',
                               array($threadId));

            foreach ($rows as $row) {
                $comments[] = new self($row);

            }

            return $comments;
        }

        //inserting a comment to a certain thread_id to database
        public function write(Comment $comment, $threadId, $session_id)
        {
            $thread = new Thread();
            if (!$comment->validate()) {
                throw new ValidationException('invalid comment');
            }

            $db = DB::conn();
            $db->query('INSERT INTO comment 
                        SET thread_id = ?, body = ?, created = NOW(), userid = ?',
                        array($threadId, $comment->body, $session_id));
        }

 } 