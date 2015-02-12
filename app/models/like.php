<?php 

/**
* 
*/
class Like extends AppModel
{
    public static function getCount()
    {
        $like_count = array();
        $db = DB::conn();
        $rows = $db->rows('SELECT comment_id, count(user_id) as liked FROM liked GROUP BY comment_id ORDER BY count(user_id) DESC');

        foreach ($rows as $row) {
            $like_count[] = new self($row);
        }

        return $like_count;
    }
}