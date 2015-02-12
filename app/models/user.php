<?php 
class User extends Appmodel
{
    const MIN_LENGTH = 8;
    const MAX_LENGTH = 16;
    const MIN_LENGTH_NAME = 1;

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
                    )
                ),
            'firstname' => array(
                'length' => array(
                    'validate_between', self::MIN_LENGTH_NAME, self::MAX_LENGTH
                    )
                ),
            'lastname' => array(
                'length' => array(
                    'validate_between', self::MIN_LENGTH_NAME, self::MAX_LENGTH
                    )
                ),
            'old_password' => array(
                'match_check' => array(
                    'check_password'
                    ),
                ),
            );

    /**
    * get all user
    */
    public static function getAllUser()
    {  
        $users = array();
        $db = DB::conn();

        $rows = $db->rows('SELECT * FROM user');

        foreach ($rows as $row) {
            $users[] = new self($row);
        }
        return $users;
    }

    /**
    * Function to add a username and password to registration database
    */
    public function register()
    {
        $current_time = date('Y-m-d H:i:s');
        $this->validate();
        if ($this->hasError()) {
            throw new ValidationException('invalid username or password');
        }
        try {
            $db = DB::conn();
            $db->begin();
            $db->insert('user', array('username' => $this->username,
                                      'password' => $this->password,
                                      'created' => $current_time,
                                      'firstname' => $this->firstname,
                                      'lastname' => $this->lastname,
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

    //compare the password enter by the user to the password in database
    public function check_password()
    {
        if ($this->old_password === $_SESSION['password']) {
            return true;
        } else {
            return false;
        }
    }

    //function for comparing (username/password) entered by user to (username/password) database
    public function login()
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM user 
                         WHERE BINARY username = ? 
                         AND BINARY password = ?',
                         array($this->username, $this->password));
            
        if (!$row) {
            $this->login_flag = false;
            throw new RecordNotFoundException('Invalid username/password');
        }

        return $row;
    }

    /**
    * update information of user
    * @param $session_id
    */
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

    /**
    * get all user
    * @param $id
    */
    public function getAll($id)
    {
        $users = array();

        $db = DB::conn();
        $rows = $db->rows('SELECT * FROM user WHERE id = ?', array($id));

        foreach ($rows as $row) {
            $users[] = $row;
        }

        return $users;
    }

    public function updateUserProfile($session_id)
    {
        $this->validate();
        if ($this->hasError()) {
            throw new ValidationException('invalid firstname/lastname');
        }
        try {
            $db = DB::conn();
            $db->begin();
            $db->update('user', array('firstname' => $this->firstname,
                                      'lastname' => $this->lastname),
                                array('id' => $session_id));
            $db->commit();
        } catch (Exception $e) {
            $db->rollback();
        }
    }

}
 