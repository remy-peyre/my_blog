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
    public function getAllUsers()
    {
        $data = $this->DBManager->findAllSecure("SELECT * FROM users");
        return $data;
    }
    public function getAllUsersWithoutAdmin()
    {
        $username = 'remcos75';
        $data = $this->DBManager->findAllSecure("SELECT * FROM users WHERE username != :username",
                                                ['username' => $username]);
        return $data;
    }
    public function userCheckEditProfil($data){
        $isFormGood = true;
        $errors = array();
        if (!isset($data['username']) || !$this->usernameValid($data['username'])) {
            $errors['username'] = 'Veuillez saisir un pseudo de 6 caractères minimum';
            $isFormGood = false;
        }
        $data2 = $this->getUserByUsername($data['username']);
        if($data2 !== false && (int)$data2['id'] != (int)$data['id']){
            $errors['username'] = 'Le pseudo existe déjà';
            $isFormGood = false;
        }
        if (!isset($data['firstname']) || strlen($data['firstname']) < 2) {
            $errors['firstname'] = 'Veuillez saisir un nom de 2 caractères minimum';
            $isFormGood = false;
        }
        if (!isset($data['lastname']) || strlen($data['lastname']) < 2) {
            $errors['lastname'] = 'Veuillez saisir un prénom de 2 caractères minimum';
            $isFormGood = false;
        }
        if (!isset($data['birthday']) || !$this->birthdayValid($data['birthday'])) {
            $errors['birthday'] = 'Date de naissance non conforme';
            $isFormGood = false;
        }
        return $isFormGood;
    }

    public function userEditProfil($data){
        $username = $data['username'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $birthday = $data['birthday'];
        $id = (int)$data['id'];

        $data2 = $this->getUserByUsername($id);
        if($data2['username'] != $username){
            rename('uploads/'.$_SESSION['user_username'],'uploads/'.$username);
        }
        return $this->DBManager->findOneSecure(
            "UPDATE users SET username = :username, firstname = :firstname,lastname = :lastname,  birthday = :birthday WHERE id=:id",
                ['username' => $username,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'birthday' => $birthday,
                    'id' => $id]);
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
        $data2 = $this->getUserByUsername($data['username']);
        if($data2 !== false){
            $errors['username'] = 'Le pseudo existe déjà';
            $isFormGood = false;
        }
        if(!isset($data['password']) || !$this->passwordValid($data['password'])){
            $errors['password'] = "Veiller saisir un mot de passe valide ".'<br>'."Minimum : 8 caractères avec au moins une lettre majuscule et un nombre";
            $isFormGood = false;
        }
        if($this->passwordValid($data['password']) && $data['password'] !== $data['verifpassword']){
            $errors['password'] = "Les deux mot de passe ne sont pas identiques";
            $isFormGood = false;
        }

        if (!isset($data['firstname']) || strlen($data['firstname']) < 2) {
            $errors['firstname'] = 'Veuillez saisir un nom de 2 caractères minimum';
            $isFormGood = false;
        }
        if (!isset($data['lastname']) || strlen($data['lastname']) < 2) {
            $errors['lastname'] = 'Veuillez saisir un prénom de 2 caractères minimum';
            $isFormGood = false;
        }
        if (!isset($data['birthday']) || !$this->birthdayValid($data['birthday'])) {
            $errors['birthday'] = 'Date de naissance non conforme';
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
    public function userRegister($data)
    {
        $user['username'] = $data['username'];
        $user['password'] = $this->userHash($data['password']);
        $user['firstname'] = $data['firstname'];
        $user['lastname'] = $data['lastname'];
        $user['birthday'] = $data['birthday'];
        mkdir('uploads/'.$user["username"]);
        $this->DBManager->insert('users', $user);
    }
    public function userCheckLogin($data)
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        $isFormGood = true;
        $errorsLogin = array();

        $user = $this->getUserByUsername($data['username']);
        if ($user === false) {
            $errorsLogin['username'] = 'Pseudo non valide';
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
        return $isFormGood;

    }
    public function userLogin($username)
    {
        $data = $this->getUserByUsername($username);
        if ($data === false)
            return false;
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['user_username'] = $data['username'];
        return true;
    }

    private function usernameValid($username){
        return preg_match('`^([a-zA-Z0-9-_]{6,20})$`', $username);
    }

    private function passwordValid($password){
        return preg_match('`^([a-zA-Z0-9-_]{8,20})$`', $password);
    }
    private function birthdayValid($birthday){
        $day = (int)substr($birthday,0,2);
        $month = (int)substr($birthday,3,2);
        $year = (int)substr($birthday,6,4);
        return checkdate($month,$day,$year);
    }

    private function userHash($pass)
    {
        $hash = password_hash($pass, PASSWORD_BCRYPT, ['salt' => 'saltysaltysaltysalty!!']);
        return $hash;
    }

}
