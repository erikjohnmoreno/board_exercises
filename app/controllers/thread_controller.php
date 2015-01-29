<?php 
    /**
    * 
    */
    class ThreadController extends AppController
    {
        const MAX_THREADS_PER_PAGE = 5;

        public function index()
        {
            $threads = Thread::getAllThreads(); // GET all list of threads from database
            $current = max(Param::get('page'),SimplePagination::MIN_PAGE_NUM);//get page number specified in view/index
            $pagination = new SimplePagination($current, self::MAX_THREADS_PER_PAGE);
            $remaining_threads = array_slice($threads, $pagination->start_index + SimplePagination::MIN_PAGE_NUM);
            $pagination->checkLastPage($remaining_threads);

            $page_links = createPaginationLinks(count($threads),$current, $pagination->count);

            $threads = array_slice($threads, $pagination->start_index, $pagination->count);
            $this->set(get_defined_vars());
        }

        public function view_user_thread()
        {    

            //pagination        
            $threads = Thread::getAll($_SESSION['id']); // get all list of threads from current user login database
            $current = max(Param::get('page'), SimplePagination::MIN_PAGE_NUM);//get page number specified in view/view_user_thread
            $pagination = new SimplePagination($current, self::MAX_THREADS_PER_PAGE);

            $remaining_threads = array_slice($threads, $pagination->start_index + SimplePagination::MIN_PAGE_NUM);
            $pagination->checkLastPage($remaining_threads);

            $page_links = createPaginationLinks(count($threads), $current, $pagination->count);
            $threads = array_slice($threads, $pagination->start_index, $pagination->count);

            $this->set(get_defined_vars());
        }
        
        public function create()
        {
            $thread = new Thread();
            $comment = new Comment();
            $page = Param::get('page_next', 'create');
            
            switch ($page) {
                case 'create':
                    break;
                
                case 'create_end':
                    $thread->title = Param::get('title');
                    $comment->body = Param::get('body');
                    try {
                        $thread->create($comment, $_SESSION['id']);
                        
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
