<?php  
	/**
	* 
	*/
	class UserController extends AppController
	{
		
		public function register()
		{
			$user = new User;
			$page = Param::get('page_next', 'register');

			switch ($page) {
				case 'register':
					break;
			
				case 'register_end':
					$user->username = Param::get('username');
					$user->password = Param::get('password');
					try {
						$user->register();

					} catch (ValidationException $e) {
						$page = 'register';
					}

				default:
					//throw new NotFoundException("{$page} not found");
					break;
			}

			$this->set(get_defined_vars());
			$this->render($page);
		}

		public function login()
		{
			$user = new User;
			$page = Param::get('page_next', 'login');

			switch ($page) {
				case 'login':
					break;
				
				case 'login_next':
					$user->username = Param::get('username');
					$user->password = Param::get('password');
					try {
						$user->login();
					} catch (RecordNotFoundException $e) {
						$page = 'login';
					}


				default:
					break;
			}

			$this->set(get_defined_vars());
			$this->render($page);
			
			
		}

		
	}
?>