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
        foreach($AllUsersArticles as $article){
            $AllImagesNames[$article['matricule']] = substr(strrchr($article['image'], "/"), 1);
            $user = $manager->getUserById((int)$article['user_id']);
            $AllUsernames[(int)$article['user_id']] = $user['username'];
            $contentArticle[$article['matricule']] = substr($article['content'], 0, 150).'...';
        }
        echo $this->renderView('home.html.twig',
                                   ['AllUsersArticles' => $AllUsersArticles,
                                       'AllUsernames'=>$AllUsernames,
                                       'AllImagesNames' => $AllImagesNames,
                                       'contentArticle' => $contentArticle]);
    }


    public function profilAction()
    {
        if (!empty($_SESSION['user_id'])) {
            $manager = UserManager::getInstance();
            $article = ArticleManager::getInstance();

            $countArticles = $article->countArticles($_SESSION['user_id']);
            $numberOfArticles = array();
            $numberOfComments = array();

            $countComments = $article->countComments($_SESSION['user_id']);

            foreach ($countComments as $value) {
                $numberOfComments[$_SESSION['user_id']] = $value['COUNT(*)'];
            }
            foreach ($countArticles as $value) {
                $numberOfArticles[$_SESSION['user_id']] = $value['COUNT(*)'];
            }
            $user = $manager->getUserById($_SESSION['user_id']);
            $username = $user['username'];
            $lastname = strtoupper($user['lastname']); //uppercase
            $firstname = ucwords($user['firstname']); //Convert the first character of each word to uppercase
            $birthday= $user['birthday'];
            echo $this->renderView('profil.html.twig',
                                    ['username' => $username,
                                        'firstname' => $firstname,
                                        'lastname' => $lastname,
                                        'birthday' => $birthday,
                                        'numberOfArticles' => $numberOfArticles[$_SESSION['user_id']],
                                        'numberOfComments' => $numberOfComments[$_SESSION['user_id']],
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
        $username = array();
        foreach ($AllUsersArticles as $article){
            $AllArticleComments[$article['id']] = $articles->ArticleComments($article['id']);
        }
        foreach ($AllArticleComments as $comment){
            if(!empty($comment)) {
                foreach ($comment as $contentComment) {
                    $AllUsers[$contentComment['user_id']] = $users->getUserById($contentComment['user_id']);
                }
            }
        }
        foreach ($AllUsers as $user){
            $userWhoComment[$user['id']] = $user['username'];
            $username[$user['id']] = $user['username'];
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $res = $articles->userCheckComment($_POST);
            if ($res['isFormGood']) {
                $articles->userInsertComment($res['data']);
            }
        }
        echo $this->renderView('read_article.html.twig',
            ['AllUsersArticles' => $AllUsersArticles,
             'AllArticleComments' => $AllArticleComments,
             'userWhoComment' => $userWhoComment,
             'userConnect' => $userConnect,
             'username' => $username]);
    }
    public function usersprofilAction()
    {
        $users = UserManager::getInstance();
        $article = ArticleManager::getInstance();
        $AllUsers = $users -> getAllUsers();
        $numberOfArticles = array();
        $numberOfComments = array();
        $username = array();
        $firstname = array();
        $lastname = array();
        $birthday = array();

        foreach ($AllUsers as $user){
            $countArticles = $article->countArticles($user['id']);
            $countComments = $article->countComments($user['id']);
            $username[$user['username']] = $user['username'];
            $firstname[$user['username']] = $user['firstname'];
            $lastname[$user['username']] = $user['lastname'];
            $birthday[$user['username']] = $user['birthday'];
            foreach ($countArticles as $value){
                $numberOfArticles[$user['username']] = $value['COUNT(*)'];
            }
            foreach ($countComments as $value){
                $numberOfComments[$user['username']] = $value['COUNT(*)'];
            }
        }
        echo $this->renderView('usersprofil.html.twig',
            ['AllUsers' => $AllUsers,
                'numberOfArticles' => $numberOfArticles,
                'numberOfComments' => $numberOfComments]);
    }

    public function saisonAction()
    {
        if (!empty($_SESSION['user_id']))
            echo $this->renderView('saison.html.twig');
        else
            $this->redirect('login');
    }
}
