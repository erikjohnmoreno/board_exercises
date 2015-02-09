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
                $user->username = trim(Param::get('username'));
                $user->password = trim(Param::get('password'));
                $user->firstname = trim(Param::get('firstname'));
                $user->lastname = trim(Param::get('lastname'));
                $user->email = trim(Param::get('email'));
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
        if (isset($_SESSION['id'])) {
            header('Location: /thread/index');       
        } else {
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
                        $_SESSION['firstname'] = $account['firstname'];
                        redirect('/thread/index');
                    } catch (RecordNotFoundException $e) {
                        $page = 'login';
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

    public function logout()
    {
        session_destroy();
        header('Location: /user/login');
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
                    redirect('/user/user_profile');
                } catch (ValidationException $e) {
                    $page = 'update_info';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }

        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function user_profile()
    {
        $user = new User();
        $users = $user->getAll($_SESSION['id']);
        $this->set(get_defined_vars());
    }

    public function update_user_profile()
    {
        $user = new User();
        $page = Param::get('page_next','update_user_profile');

        switch ($page) {
            case 'update_user_profile':
                break;   
            case 'update_info_next':                   
                $user->firstname = trim(Param::get('firstname'));
                $user->lastname = trim(Param::get('lastname'));
                try {                         
                    $user->updateUserProfile($_SESSION['id']); 
                } catch (ValidationException $e) {
                    $page = 'update_user_profile';
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
