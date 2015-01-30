<?php 
    //Model for user registration and login
    class User extends Appmodel
    {
        const MIN_LENGTH = 8;
        const MAX_LENGTH = 16;


        public $login_flag = true; //indicator that tells user is currently login

        public $validation = array(
                'username' => array(
                    'length' => array(
                        'validate_between', self::MIN_LENGTH, self::MAX_LENGTH
                        ),
                    'duplicate' => array(
                        'check'
                        )
                    ),

                'password' => array(
                    'length' => array(
                        'validate_between', self::MIN_LENGTH, self::MAX_LENGTH
                        ),
                    'duplicate' => array(
                        'check'
                        ),
                    ),

                'old_password' => array(
                    'match_check' => array(
                        'check_password'
                        ),
                    ),
                );

        //Function to add a username and password to registration database
        public function register()
        {
            $this->validate();
            if ($this->hasError()) {
                throw new ValidationException('invalid username or password');

            }
            try {
                  $db = DB::conn();
                  $db->begin();
                  $db->insert('user', array('username' => $this->username,
                                            'password' => $this->password,
                                            'email' => $this->email));
            
                  $db->commit();
            } catch (Exception $e) {
                  $db->rollback();
            }
          
        }

        //function to check if username already exists
        public function check()
        {
            $db = DB::conn();
            $rows = $db->rows('SELECT username, email 
                               FROM user WHERE username = ? OR email = ?',
                               array($this->username, $this->email));

            return empty($rows);
            
        }


        public function check_password()
        {
            if ($this->old_password === $_SESSION['password']) {
                return true;
            } 
        }

        //function for comparing (username password) login and (username/password) database
        public function login()
        {
            $db = DB::conn();
            $row = $db->row('SELECT id, username, password 
                             FROM user 
                             WHERE username = ? 
                             AND password = ?',
                             array($this->username, $this->password));
            
            if(!$row)
            {
                $this->login_flag = false;
                throw new RecordNotFoundException('Invalid username/password');
            }

            return $row;
        }

        public function updateInfo($session_id)
        {
            $this->validate();
            if ($this->hasError()) {
                throw new ValidationException('password not match');
            }
            try {

                $db = DB::conn();
                $db->begin();
                $db->update('user', array('password' => $this->new_password), array('id' => $session_id));
                $db->commit();

            } catch (Exception $e) {
                $db->rollback();
            }

        }

    }
 