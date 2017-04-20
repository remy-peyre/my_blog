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

    public function userCheckArticle($data)
    {
        $isFormGood = true;
        $errors = array();
        if(isset($_FILES['add_file']['name']) && !empty($_FILES)){
            $data['image'] = $_FILES['add_file']['name'];
            $data['image_tmp_name'] = $_FILES['add_file']['tmp_name'];
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
            return $data;
        }
    }
    public function userInsertArticle($data)
    {
        $pathImage = 'uploads/'.$_SESSION['user_username'].'/'.$data['image'];
        $article['title'] = $data['title'];
        $article['content'] = $data['content'];
        $article['image'] = $pathImage;
        $article['user_id'] = $_SESSION['user_id'];
        $article['date'] = $this->getDatetimeNow();
        move_uploaded_file($data['image_tmp_name'],$pathImage);
        $this->DBManager->insert('articles', $article);
    }

    public function userArticles(){
        $id_user = $_SESSION['user_id'];
        return $this->DBManager->findAllSecure('SELECT * FROM articles WHERE user_id = :user_id ORDER BY DATE DESC', ['user_id' => $id_user]);
    }
    public function AllUsersArticles(){
        return $this->DBManager->findAllSecure('SELECT * FROM articles ORDER BY DATE DESC');
    }
    public function getDatetimeNow() {
        date_default_timezone_set('Europe/Paris');
        return date("Y-m-d H:i:s");
    }
}
