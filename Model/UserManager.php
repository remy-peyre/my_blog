<?php

namespace Model;

class UserManager
{
    private $DBManager;
    
    private static $instance = null;
    public static function getInstance()
    {
        if (self::$instance === null)
            self::$instance = new UserManager();
        return self::$instance;
    }
    
    private function __construct()
    {
        $this->DBManager = DBManager::getInstance();
    }

    public function getUserById($id)
    {
        $id = (int)$id;
        $data = $this->DBManager->findOne("SELECT * FROM users WHERE id = ".$id);
        return $data;
    }
    
    public function getUserByUsername($username)
    {
        $data = $this->DBManager->findOneSecure("SELECT * FROM users WHERE username = :username",
                                ['username' => $username]);
        return $data;
    }


    
    public function userCheckRegister($data)
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        $isFormGood = true;
        $errors = array();

        if (!isset($data['username']) || !$this->usernameValid($data['username'])) {
            $errors['username'] = 'Veuillez saisir un pseudo de 6 caractères minimum';
            $isFormGood = false;
        }
        if(!isset($data['password']) || !$this->passwordValid($data['password'])){
            $errors['password'] = "Veiller saisir un mot de passe valide ".'<br>'."Minimum : 8 caractères avec au moins une lettre majuscule et un nombre)";
            $isFormGood = false;
        }
        if($this->passwordValid($data['password']) && $data['password'] !== $data['verifpassword']){
            $errors['password'] = "Les deux mot de passe ne sont pas identiques";
            $isFormGood = false;
        }

        if (!isset($data['firstname']) || strlen($data['firstname']) < 4) {
            $errors['firstname'] = 'Veuillez saisir un pseudo de 4 caractères minimum';
            $isFormGood = false;
        }
        if (!isset($data['lastname']) || strlen($data['lastname']) < 4) {
            $errors['lastname'] = 'Veuillez saisir un pseudo de 4 caractères minimum';
            $isFormGood = false;
        }

        if($isFormGood)
        {
            json_encode(array('success'=>true, 'user'=>$_POST));
        }
        else
        {
            echo(json_encode(array('success'=>false, 'errors'=>$errors), JSON_UNESCAPED_UNICODE ,http_response_code(400)));
            exit(0);

        }
        return $isFormGood;

    }


    public function usernameValid($username){
        return preg_match('`^([a-zA-Z0-9-_]{6,20})$`', $username);
    }

    public function passwordValid($password){
        return preg_match('`^([a-zA-Z0-9-_]{8,20})$`', $password);
    }

    private function userHash($pass)
    {
        $hash = password_hash($pass, PASSWORD_BCRYPT, ['salt' => 'saltysaltysaltysalty!!']);
        return $hash;
    }
    
    public function userRegister($data)
    {
        $user['username'] = $data['username'];
        $user['password'] = $this->userHash($data['password']);
        $user['firstname'] = $data['firstname'];
        $user['lastname'] = $data['lastname'];
        $user['birthday'] = $data['birthday'];
        $this->DBManager->insert('users', $user);
    }

    public function userCheckLogin($data)
    {
        /*header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        $isFormGood = true;
        $errors = array();
        $user = $this->getUserByUsername($data['username']);
        if (empty($data['username']) || $user === false) {
            $errors['username'] = 'Veuillez saisir un pseudo valide';
            $isFormGood = false;
        }
        $hash = $this->userHash($data['password']);
        if ($user !== false && $hash !== $user['password'] && empty($data['password']))
        {
            $errors['password'] = 'Pseudo ou mot de passe incorrect';
            $isFormGood = false;
        }
        if($isFormGood)
        {
            json_encode(array('success'=>true, 'user'=>$_POST));
        }
        else
        {
            echo(json_encode(array('success'=>false, 'errors'=>$errors), JSON_UNESCAPED_UNICODE ,http_response_code(400)));
            exit(0);

        }
        return $isFormGood;
        */
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        $isFormGood = true;
        $errorsLogin = array();

        $user = $this->getUserByUsername($data['username']);
        if (isset($data['username']) && $user === false) {
            $errorsLogin['username'] = 'pseudo ou mot de passe incorrect';
            $isFormGood = false;
        }
        $hash = $this->userHash($data['password']);
        if ($user !== false && $hash !== $user['password'])
        {
            $errorsLogin['password'] = 'pseudo ou mot de passe incorrect';
            $isFormGood = false;
        }
        if($isFormGood)
        {
            json_encode(array('success'=>true, 'user'=>$_POST));
        }
        else
        {
            echo(json_encode(array('success'=>false, 'errors'=>$errorsLogin), JSON_UNESCAPED_UNICODE ,http_response_code(400)));
            exit(0);
        }
        return false;

    }


    public function userLogin($username)
    {
        $data = $this->getUserByUsername($username);
        if ($data === false)
            return false;
        $_SESSION['user_id'] = $data['id'];
        return true;
    }
}
