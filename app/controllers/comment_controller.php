<?php 
    /**
    * 
    */
class CommentController extends AppController
{
    const MAX_COMMENT_PER_PAGE = 5;
    const MAX_ADJACENT_PAGE = 8;
    public function view()
    {  
        $session_id = $_SESSION['id'];
        $thread_id = Param::get('thread_id');
        if (!$thread_id) {
            redirect(url('thread/index'));
        }
        $thread = Thread::get($thread_id);
        $comment = new Comment();       
        $comments = $comment->getByThreadId($thread->id);//getting all comments on the selected thread
        $users = $comment->getByUser();//getting all user
        $_SESSION['last_page'] = count(array_chunk($comments, self::MAX_COMMENT_PER_PAGE));//getting the last page
        $current = max(Param::get('page'), SimplePagination::MIN_PAGE_NUM);
        $pagination = new SimplePagination($current, self::MAX_COMMENT_PER_PAGE);
        $remaining_comments = array_slice($comments, $pagination->start_index + SimplePagination::MIN_PAGE_NUM);
        $pagination->checkLastPage($remaining_comments);
        $page_links = alternativePaginationLinks(count($comments), self::MAX_COMMENT_PER_PAGE, $current, self::MAX_ADJACENT_PAGE);
        $comments = array_slice($comments, $pagination->start_index, $pagination->count);
        $_SESSION['thread_id'] = $thread->id;
        $_SESSION['current_page'] = $current;

        $this->set(get_defined_vars());
    }

    public function write()
    {
        $thread_id = Param::get('thread_id');
        if (!$thread_id) {
            redirect(url('thread/index'));
        }
        $thread = Thread::get($thread_id);
        $comment = new Comment();
        $page = Param::get('page_next');

        switch ($page) {
            case 'write':
                break;
            case 'write_end':
                $comment->body = trim(Param::get('body'));
                try {
                    $comment->write($comment, $thread->id, $_SESSION['id']);
                    redirect(url('comment/view', array('page' => 1,'thread_id' => $_SESSION['thread_id'])));
                } catch (ValidationException $e) {
                    $page = 'write';
                }    
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }
        
    public function edit()
    {
        $comment = new Comment();
        $comment->comment_id = Param::get('comment_id');
        $comments = $comment->get($comment->comment_id);
        $page = Param::get('page_next', 'edit');

        switch ($page) {
            case 'edit':
                break;
            case 'edit_end':
                $comment->body = trim(Param::get('body'));
                try {
                    $comment->edit();
                    redirect(url('comment/view', array('thread_id' => $_SESSION['thread_id'])));
                } catch (ValidationException $e) {
                    $page = 'edit';
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
        $comment = new Comment();
        $comment->comment_id = Param::get('comment_id');
        try {
            $comments = Comment::get($comment->comment_id);
            if ($comments['userid'] == $_SESSION['id']) {
                $comment->unlike($_SESSION['id']);
                $comment->delete($comment->comment_id);
            }
        } catch (Exception $e) {
                throw new NotFoundException("comment_id not found");
        }

        redirect(url('comment/view', array('thread_id' => $_SESSION['thread_id'])));
        $this->set(get_defined_vars()); 
        $this->render($page);

    }

    public function like_comment()
    {
        $comment = new Comment();
        $comment->comment_id = Param::get('comment_id');
        $comment->thread_id = Param::get('thread_id');
        $comment->like($_SESSION['id']);

        redirect(url('comment/view', array('page' => $_SESSION['current_page'],'thread_id' => $_SESSION['thread_id'])));
        $this->set(get_defined_vars());
        
    }

    public function unlike_comment()
    {
        $comment = new Comment();
        $comment->comment_id = Param::get('comment_id');
        $comment->unlike($_SESSION['id']);
        redirect(url('comment/view', array('page' => $_SESSION['current_page'],'thread_id' => $_SESSION['thread_id'])));
        $this->set(get_defined_vars());
    }

    public function top_comments()
    {
        $comment = new Comment();
        $thread = new Thread();

        $threads = $thread->getAllThreads();
        $comments = $comment->getAll();
        $comment_top = $comment->getCountFromLike();

        $current = max(Param::get('page'), SimplePagination::MIN_PAGE_NUM);
        $pagination = new SimplePagination($current, self::MAX_COMMENT_PER_PAGE);
        $remaining_comments = array_slice($comment_top, $pagination->start_index + SimplePagination::MIN_PAGE_NUM);
        $pagination->checkLastPage($remaining_comments);

        $page_links = alternativePaginationLinks(count($comment_top), self::MAX_COMMENT_PER_PAGE, $current, self::MAX_ADJACENT_PAGE);
        $comment_top = array_slice($comment_top, $pagination->start_index, $pagination->count);

        $this->set(get_defined_vars());

    }
}
