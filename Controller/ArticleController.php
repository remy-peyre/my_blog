<?php

namespace Controller;

use Model\ArticleManager;
use Model\UserManager;

class ArticleController extends BaseController
{
    public function add_articleAction()
    {
        $userIsConnect = '';
        if(!empty($_SESSION['user_id'])){
            $userIsConnect = true;
        }
        if (!empty($_SESSION['user_id'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $manager = ArticleManager::getInstance();
                //$manager->userCheckArticle($_POST);

                $res = $manager->userCheckArticle($_POST);
                if ($res['isFormGood']) {
                    $manager->userInsertArticle($res['data']);
                    $this->redirect('edit_article');
                }
            }
            echo $this->renderView('add_article.html.twig', ['userIsConnect' => $userIsConnect]);
        }
        else {
            $this->redirect('login');
        }
    }

    public function edit_articleAction()
    {
        $userIsConnect = '';
        if(!empty($_SESSION['user_id'])){
            $userIsConnect = true;
        }
        if (!empty($_SESSION['user_id'])) {
            $articles = ArticleManager::getInstance();
            $userArticles = $articles->userArticles();
            $username = $_SESSION['user_username'];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $articles->checkEditArticle($_POST);
                //header('Location: ?action=edit_article');
                /*if ($res['isFormGood']) {
                     $articles->editArticle($res['data']);
                 }*/
            }
            echo $this->renderView('edit_article.html.twig',
                ['userArticles' => $userArticles, 'username' => $username,
                    'userIsConnect' => $userIsConnect]);
        }
        else
            $this->redirect('login');
    }
}
