<?php 

	/**
	* 
	*/
	class ThreadController extends AppController
	{
		
		public function index()
		{
			$i = 0;
			//TODO: Get all threads
			$threads = Thread::getAllThreads();
			$current = Param::get('page');
			$pagination = new SimplePagination($current, 2);
			$divided_page = array_chunk($threads, 2, true);
			$pagination->checkLastPage($divided_page);
			$this->set(get_defined_vars());
		}

		public function view_user_thread()
		{
			$threads = Thread::getAll();
			$this->set(get_defined_vars());
		}
		
		public function create()
		{
			$thread = new Thread;
			$comment = new Comment;
			$page = Param::get('page_next', 'create');
			
			switch ($page) {
				case 'create':
					break;
				
				case 'create_end':
					$thread->title = Param::get('title');
					$comment->body = Param::get('body');
					try {
						$thread->create($comment);

					} catch (ValidationException $e) {
						$page = 'create';
					}
					break;

				default:
					throw new NotFoundException("{$page} is not found");
					break;
			}

			$this->set(get_defined_vars());
			$this->render($page);
		}
	}
 ?>
