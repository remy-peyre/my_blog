<?php

namespace Model;

class ArticleManager
{
    private $DBManager;
    private $UserManager;

    private static $instance = null;
    public static function getInstance()
    {
        if (self::$instance === null)
            self::$instance = new ArticleManager();
        return self::$instance;
    }

    private function __construct()
    {
        $this->DBManager = DBManager::getInstance();
        $this->UserManager = UserManager::getInstance();
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


    public function userCheckArticle($data)
    {
        $isFormGood = true;
        $errors = array();
        if(isset($_FILES['add_file']['name']) && !empty($_FILES)){
            $data['image'] = $_FILES['add_file']['name'];
        }else{
            $errors['image'] = 'image vide';
            $isFormGood = false;
        }
        if(isset($data['title']) && empty($data['title'])){
            $errors['title'] = 'titre vide';
            $isFormGood = false;
        }
        if(isset($data['content']) && empty($data['content'])){
            $errors['title'] = 'titre vide';
            $isFormGood = false;
        }
        if($isFormGood){
            //var_dump($data);
            return $data;
        }
    }


    public function userInsertArticle($data)
    {
        $article['title'] = $data['title'];
        $article['content'] = $data['content'];
        $article['image'] = $data['image'];
        $article['user_id'] = $_SESSION['user_id'];
        var_dump($article);
        //$this->DBManager->insert
        //$this->DBManager->insert('users', $user);
    }

}
