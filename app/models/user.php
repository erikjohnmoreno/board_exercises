<?php 
	//MODEL FOR USER REGISTRATION
	class User extends Appmodel
	{
		
		public $validation = array(
				'username' => array(
					'length' => array(
						'validate_between', 8, 16
						),
					'duplicate' => array(
						'check'
						)
					),

				'password' => array(
					'length' => array(
						'validate_between', 8, 16
						)
					)
				);

		//Add user to registration database
		public function register()
		{
			$this->validate();
			if ($this->hasError()) {
				throw new ValidationException('invalid username or password');

			}
			$db = DB::conn();
			$db->begin();

			$db->query('INSERT INTO user SET username = ?, password = ?', array($this->username, $this->password));
		
			$db->commit();
		}

		public function check()
		{
			$db = DB::conn();
			$rows = $db->rows('SELECT username FROM user WHERE username = ?', array($this->username));

			return empty($rows);		
			
		}


						
				
	}
 