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
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');

        $isFormGood = true;
        $errors = array();
        $res = array();
        if(isset($_FILES['image']['name']) && !empty($_FILES)){
            $data['image'] = $_FILES['image']['name'];
            $data['image_tmp_name'] = $_FILES['image']['tmp_name'];
            $res['data'] = $data;
        }
        else{
            $errors['image'] = 'Veillez choisir une image';
            $isFormGood = false;
        }
        if(isset($data['title']) && empty($data['title'])){
            $errors['title'] = 'le champs Titre est obligatoire';
            $isFormGood = false;
        }
        if(isset($data['content']) && empty($data['content'])){
            $errors['content'] = 'Veillez remplir le contenu de l\'article';
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
        $res['isFormGood'] = $isFormGood;
        return $res;


    }
    public function userInsertArticle($data)
    {
        $pathImage = 'uploads/'.$_SESSION['user_username'].'/'.$data['image'];
        $article['title'] = $data['title'];
        $article['content'] = $data['content'];
        $article['image'] = $pathImage;
        $article['user_id'] = $_SESSION['user_id'];
        $article['date'] = $this->getDatetimeNow();
        $article['matricule'] = $this->RandomString();
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

    public function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 20; $i++) {
            $randstring .= $characters[mt_rand(0, strlen($characters))];
        }
        return $randstring;
    }
}
