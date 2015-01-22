<?php 
	/**
	* 
	*/
	class Thread extends AppModel
	{
		
		public static function getAll()
		{
			$thread = array();

			$db = DB::conn();

			$rows = $db->rows('SELECT * FROM thread');

			foreach ($rows as $row) {
				$threads[] = new Thread($row);
			}
			return $threads;
		}
	}
 ?>