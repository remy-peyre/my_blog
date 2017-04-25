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

    public function userCheckComment($data){
        /*header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        */
        $isFormGood = true;
        $errors = array();
        if(isset($data['content']) && empty($data['content'])){
            $errors['content'] = 'Veillez remplir les champs';
            $isFormGood = false;
        }
        if(isset($data['content']) && !empty($data['content']) && strlen($data['content'])>5000){
            $errors['content'] = 'Max 5000 caractère';
            $isFormGood = false;
        }
        /*if($isFormGood)
        {
            json_encode(array('success'=>true, 'user'=>$_POST));
        }
        else
        {
            echo(json_encode(array('success'=>false, 'errors'=>$errors), JSON_UNESCAPED_UNICODE ,http_response_code(400)));
            exit(0);
        }*/
        return $isFormGood;;
    }

    public function userInsertComment($data){
        $article_id = $data['article_id'];
        $user_id = $_SESSION['user_id'];
        $articleToComment = $this->getArticleById($article_id);
        $article_id = (int)$articleToComment ['id'];

        $comment['content'] = $data['content'];
        $comment['article_id'] = $article_id;
        $comment['user_id'] = $user_id;
        $comment['date'] = $this->getDatetimeNow();
        $this->DBManager->insert('comments', $comment);
    }

    public function getArticleById($article_id)
    {
        $id = (int)$article_id;
        $data = $this->DBManager->findOne("SELECT * FROM articles WHERE id = ".$id);
        return $data;
    }

    public function userInsertArticle($data)
    {
        $pathImage = 'uploads/'.$_SESSION['user_username'].'/'.$data['image'];
        $article['title'] = htmlentities($data['title']);
        $article['content'] = htmlentities($data['content']);
        $article['image'] = $pathImage;
        $article['user_id'] = $_SESSION['user_id'];
        $article['date'] = $this->getDatetimeNow();
        $article['matricule'] = $this->getMatricule();
        move_uploaded_file($data['image_tmp_name'],$pathImage);
        $this->DBManager->insert('articles', $article);
    }

    public function userArticles(){
        $id_user = $_SESSION['user_id'];
        return $this->DBManager->findAllSecure('SELECT * FROM articles WHERE user_id = :user_id ORDER BY DATE DESC', ['user_id' => $id_user]);
    }

    public function countArticles($user_id){
        return $this->DBManager->findAllSecure('SELECT COUNT(*) FROM articles WHERE user_id = :user_id', ['user_id' => $user_id]);
    }

    public function countComments($user_id){
        $data =  $this->DBManager->findAllSecure('SELECT * FROM articles WHERE user_id = :user_id', ['user_id' => $user_id]);
        $article_id = '';
        foreach ($data as $article){
            $article_id = $article['id'];
        }
        $data2 =  $this->DBManager->findAllSecure('SELECT COUNT(*) FROM comments WHERE article_id = :article_id', ['article_id' => $article_id]);
        return $data2;
    }

    public function ArticleComments($id){
        $article_id = (int)$id;
        return $this->DBManager->findAllSecure('SELECT * FROM comments WHERE article_id = :article_id ORDER BY DATE DESC', ['article_id' => $article_id]);
    }

    public function AllUsersArticles(){
        return $this->DBManager->findAllSecure('SELECT * FROM articles ORDER BY DATE DESC');
    }
    public function getDatetimeNow() {
        date_default_timezone_set('Europe/Paris');
        return date("Y-m-d H:i:s");
    }

    public function getMatricule()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 20; $i++) {
            $randstring .= $characters[mt_rand(0, strlen($characters))];
        }
        return $randstring;
    }
}
