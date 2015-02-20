<?php 
    /**
    * 
    */
class ThreadController extends AppController
{
    const MAX_THREADS_PER_PAGE = 5;
    const MAX_ADJACENT_PAGE = 8;

    public function index()
    {
        $session_id = $_SESSION['id'];
        $session_firstname = $_SESSION['firstname'];
        
        $user = new User();
        $users = $user->getAllUser();
        $threads = Thread::getAllThreads(); // GET all list of threads from database
        $current = max(Param::get('page'),SimplePagination::MIN_PAGE_NUM);//get page number specified in view/index
        $pagination = new SimplePagination($current, self::MAX_THREADS_PER_PAGE);
        $remaining_threads = array_slice($threads, $pagination->start_index + SimplePagination::MIN_PAGE_NUM);
        $pagination->checkLastPage($remaining_threads);
        $page_links = alternativePaginationLinks(count($threads), self::MAX_THREADS_PER_PAGE, $current, self::MAX_ADJACENT_PAGE);
        $threads = array_slice($threads, $pagination->start_index, $pagination->count);

        $this->set(get_defined_vars());
    }

    public function user_thread()
    {
        $session_id = $_SESSION['id'];
        $session_firstname = $_SESSION['firstname'];

        $threads = Thread::getAll($_SESSION['id']); // get all list of threads from current user login database
        $current = max(Param::get('page'), SimplePagination::MIN_PAGE_NUM);//get page number specified in view/view_user_thread
        $pagination = new SimplePagination($current, self::MAX_THREADS_PER_PAGE);
        $remaining_threads = array_slice($threads, $pagination->start_index + SimplePagination::MIN_PAGE_NUM);
        $pagination->checkLastPage($remaining_threads);
        $page_links = alternativePaginationLinks(count($threads), self::MAX_THREADS_PER_PAGE, $current, self::MAX_ADJACENT_PAGE);
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
                $thread->title = trim(Param::get('title'));
                $comment->body = trim(Param::get('body'));
                try {
                    $thread->create($comment, $_SESSION['id']);
                    redirect(url('thread/index'));
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

    public function delete()
    {
        $thread = new Thread();
        $comment = new Comment();
        $session_id = $_SESSION['id'];
        $thread_id = Param::get('thread_id');
        $page = Param::get('page_next');

        $comment->deleteByThread($thread_id);
        $thread->deleteThread($thread_id);
        redirect(url('thread/index'));

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function top_threads()
    {
        $thread = new Thread();
        $threads = $thread->getAllThreads();
        $comment_count_by_thread = $thread->getCommentCount();

        $current = max(Param::get('page'), SimplePagination::MIN_PAGE_NUM);
        $pagination = new SimplePagination($current, self::MAX_THREADS_PER_PAGE);
        $remaining_threads = array_slice($threads, $pagination->start_index + SimplePagination::MIN_PAGE_NUM);
        $pagination->checkLastPage($remaining_threads);
        $page_links = alternativePaginationLinks(count($threads), self::MAX_THREADS_PER_PAGE, $current, self::MAX_ADJACENT_PAGE);
        $threads = array_slice($threads, $pagination->start_index, $pagination->count);
        $this->set(get_defined_vars());
    }

}
