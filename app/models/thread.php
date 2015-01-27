<?php 
	/**
	* 
	*/
	class Thread extends AppModel
	{
		public $validation = array(

			'title' => array(
				'length' => array(
					'validate_between', 1, 30,
					),
				),
			);


		public static function getAll()
		{
			$threads = array();

			$db = DB::conn();

			$rows = $db->rows('SELECT * FROM thread WHERE userid = ?', array($_SESSION['id']));

			foreach ($rows as $row) {
				$threads[] = new Thread($row);
			}
			return $threads;
		}

		public static function get($id)
		{
			$db = DB::conn();

			$row = $db->row('SELECT * FROM thread WHERE id = ?', array($id));

			if (!$row) {
				throw new RecordNotFoundException('no record found');
			}

			return new self($row);		
		}

		public function getComments()
		{
			$comments = array();

			$db = DB::conn();

			$rows = $db->rows('SELECT * FROM user INNER JOIN comment ON user.id = comment.userid WHERE comment.thread_id = ? ORDER BY comment.created ASC', array($this->id));

			foreach ($rows as $row) {
				$comments[] = new Comment($row);

			}

			return $comments;
		}

		public function write(Comment $comment)
		{
			if (!$comment->validate()) {
				throw new ValidationException('invalid comment');
			}

			$db = DB::conn();
			$db->query(
				'INSERT INTO comment SET thread_id = ?, body = ?, created = NOW(), userid = ?',
				array($this->id, $comment->body, $_SESSION['id'])
				);

		}

		public function create(Comment $comment)
		{
			$this->validate();
			$comment->validate();
			if ($this->hasError() || $comment->hasError()) {
				throw new ValidationException('invalid thread or comment');
			}

			$db = DB::conn();
			$db->begin();

			$db->query('INSERT INTO thread SET title = ?, created = NOW(), userid = ?', array($this->title, $_SESSION['id']));

			$this->id = $db->lastInsertId();

			$this->write($comment);

			$db->commit();
		}

	}
 ?>