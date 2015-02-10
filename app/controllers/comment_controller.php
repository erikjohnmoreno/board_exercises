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
        $thread = Thread::get(Param::get('thread_id'));
        $_SESSION['thread_id'] = $thread->id;
        $comment = new Comment();       
        $comments = $comment->getComments($thread->id);
        $_SESSION['last_page'] = count(array_chunk($comments, self::MAX_COMMENT_PER_PAGE));//getting the last page
        $current = max(Param::get('page'), SimplePagination::MIN_PAGE_NUM);
        $pagination = new SimplePagination($current, self::MAX_COMMENT_PER_PAGE);
        $remaining_comments = array_slice($comments, $pagination->start_index + SimplePagination::MIN_PAGE_NUM);
        $pagination->checkLastPage($remaining_comments);
        $page_links = createPaginationLinks(count($comments), $current, $pagination->count,'thread_id='.$thread->id);
        $comments = array_slice($comments, $pagination->start_index, $pagination->count);
        $_SESSION['current_page'] = $current;

        $this->set(get_defined_vars());
    }

    public function write()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $comment = new Comment();
        $page = Param::get('page_next');

        switch ($page) {
            case 'write':
                break;
            case 'write_end':
                $comment->body = trim(Param::get('body'));
                try {
                    $comment->write($comment, $thread->id, $_SESSION['id']);
                    echo "$current_page";
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
        $comments = $comment->getAllComments($comment->comment_id);
        $page = Param::get('page_next', 'edit');

        switch ($page) {
            case 'edit':
                break;                
            case 'edit_end':                    
                $comment->body = Param::get('body');
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

        $comment->delete($comment->comment_id);
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
        $comments = $comment->getLikeCount();

        $this->set(get_defined_vars());

    }
        
}
