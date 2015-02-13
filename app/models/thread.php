<?php 
/**
* 
*/
class Thread extends AppModel
{
    const MIN_LENGTH_TITLE = 1;
    const MAX_LENGTH_TITLE = 30;

    public $validation = array(
                'title' => array(
                    'length' => array(
                        'validate_between', self::MIN_LENGTH_TITLE, self::MAX_LENGTH_TITLE,
                        ),
                    ),
                );

    /**
    * function to get all threads of user currently login
    * @param $session_id
    */
    public static function getAll($session_id)
    {
        $threads = array();
        $db = DB::conn();
        
        $rows = $db->rows('SELECT * FROM thread 
                           WHERE userid = ?', array($session_id));

        foreach ($rows as $row) {
            $threads[] = new self($row);
        }
        return $threads;
    }

    /**
    *function to get all threads from database
    */
    public static function getAllThreads()
    {
        $threads = array();
        $db = DB::conn();

        $rows = $db->rows('SELECT * FROM thread ORDER BY created DESC');

        foreach ($rows as $row) {
            $threads[] = new self($row);
        }
        return $threads;
    }

    /**
    * get thread function
    * @param $id
    */
    public static function get($id)
    {
        $db = DB::conn();

        $row = $db->row('SELECT * FROM thread 
                         WHERE id = ?', array($id));

        if (!$row) {
            throw new RecordNotFoundException('no record found');
        }

        return new self($row);
    }

    /**
    * inserting a comment to database
    * @param $comment
    * @param $session_id
    */
    public function create(Comment $comment, $session_id)
    {
        $instant_comment = new Comment();
        $this->validate();
        $comment->validate();

        if ($this->hasError() || $comment->hasError()) {
            throw new ValidationException('invalid thread or comment');
        }
        try {
            $db = DB::conn();
            $db->begin();
            $db->insert('thread', array('title' => $this->title,
                                        'created' => date('Y-m-d H:i:s'),
                                        'userid' => $session_id));

            $this->id = $db->lastInsertId();
            $instant_comment->write($comment, $this->id, $session_id);

            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
        }           
    }

    /**
    * delete thread function
    * @param $thread_id
    */
    public function deleteThread($thread_id)
    {
        try {
            $db = DB::conn();
            $db->begin();
            $db->query('DELETE FROM thread WHERE id = ?', array($thread_id));
            $db->query('DELETE FROM liked WHERE thread_id = ?', array($thread_id));
            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
        }
    }

    /**
    * get comment count from comment model
    */
    public function getCommentCount()
    {
        return Comment::getByThread();
    }
}
