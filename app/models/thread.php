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

		public static function getAllThreads()
		{
			$threads = array();
			$db = DB::conn();

			$rows = $db->rows('SELECT * FROM thread');

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

		

		public function create(Comment $comment)
		{
			$instant_comment = new Comment;

			$this->validate();
			$comment->validate();
			if ($this->hasError() || $comment->hasError()) {
				throw new ValidationException('invalid thread or comment');
			}

			$db = DB::conn();
			$db->begin();

			$db->query('INSERT INTO thread SET title = ?, created = NOW(), userid = ?', array($this->title, $_SESSION['id']));

			$this->id = $db->lastInsertId();

			$instant_comment->write($comment, $this->id);

			$db->commit();
		}


	}
 ?>