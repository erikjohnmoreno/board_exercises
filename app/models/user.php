<?php 
    //Model for user registration and login
    class User extends Appmodel
    {
        public $login_flag = true; //indicator that tells user is currently login

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
                        ),
                    'duplicate' => array(
                        'check'
                        )
                    )
                );

        //Function to add a username and password to registration database
        public function register()
        {
            $this->validate();
            if ($this->hasError()) {
                throw new ValidationException('invalid username or password');

            }
            $db = DB::conn();
            $db->begin();

            $db->query('INSERT INTO user 
                        SET username = ?, password = ?', 
                        array($this->username, $this->password));
        
            $db->commit();
        }

        //function to check if username already exists
        public function check()
        {
            $db = DB::conn();
            $rows = $db->rows('SELECT username 
                               FROM user WHERE username = ?',
                               array($this->username));

            return empty($rows);
            
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

    }
 