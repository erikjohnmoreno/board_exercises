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

    //function to get all threads of user currently login 
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

    //function to get all threads from database
    public static function getAllThreads()
    {
        $threads = array();
        $db = DB::conn();

        $rows = $db->rows('SELECT * FROM thread');

        foreach ($rows as $row) {
            $threads[] = new self($row);
        }
        return $threads;
    }

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

        
    //inserting a comment to database;
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
                                        'userid' => $session_id));

            $this->id = $db->lastInsertId();
            $instant_comment->write($comment, $this->id, $session_id);

            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
        }           
    }

    public function delete($thread_id)
    {
        $comment = new Comment();
        try {
            $db = DB::conn();
            $db->begin();
            $db->query('DELETE FROM thread WHERE id = ?', array($thread_id));
            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
        }
    }

}
