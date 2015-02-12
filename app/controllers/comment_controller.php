<?php 
    /**
    * 
    */
class CommentController extends AppController
{
    const MAX_COMMENT_PER_PAGE = 5;

    public function view()
    {  
        $session_id = $_SESSION['id'];
        $thread_id = Param::get('thread_id');
        if (!$thread_id) {
            throw new NotFoundException("thread_id not found");
        }
        $thread = Thread::get($thread_id);
        $comment = new Comment();       
        $comments = $comment->getCommentsByThread($thread->id);//getting all comments on the selected thread
        $users = $comment->getByUser();//getting all user
        $_SESSION['last_page'] = count(array_chunk($comments, self::MAX_COMMENT_PER_PAGE));//getting the last page
        $current = max(Param::get('page'), SimplePagination::MIN_PAGE_NUM);
        $pagination = new SimplePagination($current, self::MAX_COMMENT_PER_PAGE);
        $remaining_comments = array_slice($comments, $pagination->start_index + SimplePagination::MIN_PAGE_NUM);
        $pagination->checkLastPage($remaining_comments);
        $page_links = createPaginationLinks(count($comments), $current, $pagination->count,'thread_id='.$thread->id);
        $comments = array_slice($comments, $pagination->start_index, $pagination->count);
        $_SESSION['thread_id'] = $thread->id;
        $_SESSION['current_page'] = $current;

        $this->set(get_defined_vars());
    }

    public function write()
    {
        $thread_id = Param::get('thread_id');
        if (!$thread_id) {
            throw new NotFoundException("thread_id not found");
        }
        $thread = Thread::get($thread_id)
        $comment = new Comment();
        $page = Param::get('page_next');

        switch ($page) {
            case 'write':
                break;
            case 'write_end':
                $comment->body = trim(Param::get('body'));
                try {
                    $comment->write($comment, $thread->id, $_SESSION['id']);
                    redirect("/comment/view?page={$_SESSION['last_page']}&thread_id={$_SESSION['thread_id']}");
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
        $comments = $comment->getComments($comment->comment_id);
        $page = Param::get('page_next', 'edit');

        switch ($page) {
            case 'edit':
                break;                
            case 'edit_end':                    
                $comment->body = trim(Param::get('body'));
                try {
                    $comment->edit();
                    redirect("/comment/view?thread_id={$_SESSION['thread_id']}");
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
        $page = Param::get('page_next');
        $comment->unlikeComment($_SESSION['id']);
        $comment->deleteByComment($comment->comment_id);
        redirect("/comment/view?thread_id={$_SESSION['thread_id']}");

        $this->set(get_defined_vars()); 
        $this->render($page);

    }

    public function like_comment()
    {
        $comment = new Comment();
        $comment->comment_id = Param::get('comment_id');
        $comment->likeComment($_SESSION['id']);
        redirect("/comment/view?page={$_SESSION['current_page']}&thread_id={$_SESSION['thread_id']}");
        $this->set(get_defined_vars());
        
    }

    public function unlike_comment()
    {
        $comment = new Comment();
        $comment->comment_id = Param::get('comment_id');
        $comment->unlikeComment($_SESSION['id']);
        redirect("/comment/view?page={$_SESSION['current_page']}&thread_id={$_SESSION['thread_id']}");
        $this->set(get_defined_vars());
    }

    public function top_comments()
    {
        $comment = new Comment();
        $thread = new Thread();

        $threads = $thread->getAllThreads();
        $comments = $comment->getAllComment();
        $comment_top = $comment->getCountFromLike();

        $current = max(Param::get('page'), SimplePagination::MIN_PAGE_NUM);
        $pagination = new SimplePagination($current, self::MAX_COMMENT_PER_PAGE);
        $remaining_comments = array_slice($comment_top, $pagination->start_index + SimplePagination::MIN_PAGE_NUM);
        $pagination->checkLastPage($remaining_comments);

        $page_links = createPaginationLinks(count($comment_top), $current, $pagination->count);
        $comment_top = array_slice($comment_top, $pagination->start_index, $pagination->count);

        $this->set(get_defined_vars());

    }
        
}
