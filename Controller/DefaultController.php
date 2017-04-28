<?php

namespace Controller;

use Model\UserManager;
use Model\ArticleManager;


class DefaultController extends BaseController
{
    public function homeAction()
    {

        $manager = UserManager::getInstance();
        $articles = ArticleManager::getInstance();
        $AllUsersArticles = $articles->AllUsersArticles();
        $contentArticle = array();
        $AllUsernames = array();
        $AllImagesNames = array();
        $countComments = array();
        $numberOfComments = array();
        $userIsConnect = '';

        if(!empty($_SESSION['user_id'])){
            $userIsConnect = true;
        }
        foreach($AllUsersArticles as $article){
            $AllImagesNames[$article['matricule']] = substr(strrchr($article['image'], "/"), 1);
            $user = $manager->getUserById((int)$article['user_id']);
            $AllUsernames[(int)$article['user_id']] = $user['username'];
            $contentArticle[$article['matricule']] = html_entity_decode(substr($article['content'], 0, 200).' ...');
            $countComments[$article['id']] = $articles->countCommentsForEachArticle((int)$article['id']);
        }


        $orig = 'J\'ai "sorti" le <strong>chien</strong> tout à l\'heure';
        $a = htmlentities($orig);
        $b = html_entity_decode($a);

        //echo $b;


        foreach ($countComments as $key=>$item) {
            foreach ($item as $value){
                $numberOfComments[$key] = $value['COUNT(*)'];
            }
        }


        echo $this->renderView(        'home.html.twig',
                                        [   'AllUsersArticles' => $AllUsersArticles,
                                            'AllUsernames'=>$AllUsernames,
                                            'AllImagesNames' => $AllImagesNames,
                                            'contentArticle' => $contentArticle,
                                            'numberOfComments' => $numberOfComments,
                                            'userIsConnect' => $userIsConnect,
                                        ]);
    }


    public function profilAction()
    {
        $userIsConnect = '';
        if(!empty($_SESSION['user_id'])){
            $userIsConnect = true;
        }
        if (!empty($_SESSION['user_id'])) {
            $manager = UserManager::getInstance();
            $article = ArticleManager::getInstance();

            $countArticles = $article->countArticles($_SESSION['user_id']);
            $numberOfArticles = array();
            $numberOfComments = array();
            $id = $_SESSION['user_id'];
            $countComments = $article->countComments($_SESSION['user_id']);
            //var_dump($countComments);
            $numberOfComments[$_SESSION['user_id']] = $countComments;

            foreach ($countArticles as $value) {
                $numberOfArticles[$_SESSION['user_id']] = $value['COUNT(*)'];
            }
            echo "<pre>";
            //var_dump($numberOfComments);
            echo "</pre>";
            $user = $manager->getUserById($_SESSION['user_id']);
            $username = $user['username'];
            $lastname = strtoupper($user['lastname']); //uppercase
            $firstname = ucwords($user['firstname']); //Convert the first character of each word to uppercase
            $birthday= $user['birthday'];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($manager->userCheckEditProfil($_POST)) {
                   $manager->userEditProfil($_POST);
                    header("Refresh:0");
                }
            }

            echo $this->renderView('profil.html.twig',
                                    ['username' => $username,
                                        'firstname' => $firstname,
                                        'lastname' => $lastname,
                                        'birthday' => $birthday,
                                        'numberOfArticles' => $numberOfArticles[$_SESSION['user_id']],
                                        'numberOfComments' => $numberOfComments[$_SESSION['user_id']],
                                        'id' => $id,
                                        'userIsConnect' => $userIsConnect,
                                    ]);
        }
        else{
            $this->redirect('login');
        }
    }

    public function read_articleAction()
    {
        $userConnect = '';
        if(!empty($_SESSION['user_id'])){
            $userConnect = $_SESSION['user_username'];
        }
        $articles = ArticleManager::getInstance();
        $users = UserManager::getInstance();
        $AllUsersArticles = $articles->AllUsersArticles();
        $AllArticleComments = array();
        $AllUsers = array();
        $userWhoComment = array();
        $dateComment = array();
        $username = array();
        foreach ($AllUsersArticles as $article){
            $AllArticleComments[$article['id']] = $articles->ArticleComments($article['id']);
            $username[$article['user_id']] = $users->getUserById($article['user_id'])['username'];
        }
        foreach ($AllArticleComments as $comment){
            if(!empty($comment)) {
                foreach ($comment as $contentComment) {
                    $AllUsers[$contentComment['user_id']] = $users->getUserById($contentComment['user_id']);
                    $dateComment[$contentComment['user_id']] = $contentComment['date'];
                }
            }
        }
        foreach ($AllUsers as $user){
            $userWhoComment[$user['id']] = $user['username'];
            $username[$user['id']] = $user['username'];
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($articles->userCheckComment($_POST)) {
                $articles->userInsertComment($_POST);
            }
        }
        echo $this->renderView('read_article.html.twig',
            ['AllUsersArticles' => $AllUsersArticles,
             'AllArticleComments' => $AllArticleComments,
             'userWhoComment' => $userWhoComment,
             'dateComment' => $dateComment,
             'userConnect' => $userConnect,
             'username' => $username]);
    }
    public function usersprofilAction()
    {
        $userIsConnect = '';
        if(!empty($_SESSION['user_id'])){
            $userIsConnect = true;
        }
        $users = UserManager::getInstance();
        $article = ArticleManager::getInstance();
        $AllUsers = $users -> getAllUsers();
        $numberOfArticles = array();
        $numberOfComments = array();
        foreach ($AllUsers as $user){
            $countArticles = $article->countArticles($user['id']);
            $numberOfComments[$user['id']] = $article->countComments($user['id']);
            foreach ($countArticles as $value){
                $numberOfArticles[$user['username']] = $value['COUNT(*)'];
            }
        }
        echo $this->renderView('usersprofil.html.twig',
            ['AllUsers' => $AllUsers,
                'numberOfArticles' => $numberOfArticles,
                'numberOfComments' => $numberOfComments,
                'userIsConnect' => $userIsConnect]);
    }

    public function saisonAction()
    {
        if (!empty($_SESSION['user_id']))
            echo $this->renderView('saison.html.twig');
        else
            $this->redirect('login');
    }

    public function adminAction()
    {
        if (!empty($_SESSION['user_id']))
            echo $this->renderView('admin.html.twig');
        else
            $this->redirect('login');
    }

    public function admin_userAction()
    {
        if (!empty($_SESSION['user_id']))
            echo $this->renderView('admin_user.html.twig');
        else
            $this->redirect('login');
    }

    public function admin_articleAction()
    {
        if (!empty($_SESSION['user_id']))
            echo $this->renderView('admin_article.html.twig');
        else
            $this->redirect('login');
    }

    public function admin_commentAction()
    {
        if (!empty($_SESSION['user_id']))
            echo $this->renderView('admin_comment.html.twig');
        else
            $this->redirect('login');
    }

    public function errorAction()
    {
        /*if (!empty($_SESSION['user_id']))
            echo $this->renderView('error.html.twig');
        else
            $this->redirect('error');*/
        echo $this->renderView('error.html.twig');
    }
}
