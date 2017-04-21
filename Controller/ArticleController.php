<?php

namespace Controller;

use Model\ArticleManager;
use Model\UserManager;

class ArticleController extends BaseController
{
    public function add_articleAction()
    {
        if (!empty($_SESSION['user_id'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $manager = ArticleManager::getInstance();
                $res = $manager->userCheckArticle($_POST);
                if ($res['isFormGood']) {
                    $manager->userInsertArticle($res['data']);
                }
            }
            echo $this->renderView('add_article.html.twig');
        }
        else
            $this->redirect('login');
    }

    public function edit_articleAction()
    {
        if (!empty($_SESSION['user_id'])) {
            $manager = ArticleManager::getInstance();
            $userArticles = $manager->userArticles();
            $username = $_SESSION['user_username'];
            echo $this->renderView('edit_article.html.twig', ['userArticles' => $userArticles, 'username' => $username]);
        }
        else
            $this->redirect('login');
    }
}
