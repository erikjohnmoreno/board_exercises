<?php 
    /**
    * 
    */
    class CommentController extends AppController
    {
        const MAX_COMMENT_PER_PAGE = 5;

        public function view()
        {
            $thread = Thread::get(Param::get('thread_id'));
            $comment = new Comment();        
            $comments = $comment->getComments($thread->id);
            //pagination
            $current = max(Param::get('page'), SimplePagination::MIN_PAGE_NUM);
            $pagination = new SimplePagination($current, self::MAX_COMMENT_PER_PAGE);
            $remaining_comments = array_slice($comments, $pagination->start_index + SimplePagination::MIN_PAGE_NUM);
            $pagination->checkLastPage($remaining_comments);
            $page_links = createPaginationLinks(count($comments), $current, $pagination->count,'thread_id='.$thread->id);
            $comments = array_slice($comments, $pagination->start_index, $pagination->count);

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
                    $comment->body = Param::get('body');
                    try {
                        $comment->write($comment, $thread->id, $_SESSION['id']);
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
        
    }
