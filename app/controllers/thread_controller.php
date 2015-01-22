<?php 
	/**
	* 
	*/
	class ThreadController extends AppController
	{
		
		public function index()
		{
			//TODO: Get all threads
			$threads = Thread::getALL();
			$this->set(get_defined_vars());
		}
	}
 ?>
