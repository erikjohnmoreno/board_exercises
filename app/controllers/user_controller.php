<?php  
    /**
    * 
    */
    class UserController extends AppController
    {
        
        public function register()
        {
            $user = new User();
            $page = Param::get('page_next', 'register');

            switch ($page) {
                case 'register':
                    break;
                case 'register_end':
                    $user->username = Param::get('username');
                    $user->password = Param::get('password');
                    $user->email = Param::get('email');
                    try {
                        $user->register();
                    } catch (ValidationException $e) {
                        $page = 'register';
                    }
                    break;
                default:
                    throw new NotFoundException("{$page} not found");
                    break;
            }
            $this->set(get_defined_vars());
            $this->render($page);
        }

        public function login()
        {
            $user = new User();
            $page = Param::get('page_next', 'login');

            switch ($page) {
                case 'login':
                    break;   
                case 'login_next':
                    $user->username = Param::get('username');
                    $user->password = Param::get('password');
                    try {
                        $account = $user->login();
                        $_SESSION['id'] = $account['id'];
                        $_SESSION['username'] = $account['username']; 
                        $_SESSION['password'] = $account['password'];            
                    } catch (RecordNotFoundException $e) {
                        $page = 'login';
            }
                default:
                    break;
            }

            $this->set(get_defined_vars());
            $this->render($page);            
        }

        public function logout()
        {
            session_destroy();
        }

        public function update_info()
        {
            $user = new User();
            $page = Param::get('page_next', 'update_info');

            switch ($page) {
                case 'update_info':
                    break;   
                case 'update_info_next':                   
                    $user->new_password = Param::get('new_password');
                    $user->old_password = Param::get('old_password');
                    try {                         
                            $user->updateInfo($_SESSION['id']); 
                    } catch (ValidationException $e) {
                        $page = 'update_info';
            }
                default:
                    break;
            }

            $this->set(get_defined_vars());
            $this->render($page);
        }  
        
    }
