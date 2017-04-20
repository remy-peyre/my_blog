<?php

namespace Controller;

use Model\UserManager;
use Model\ArticleManager;


class DefaultController extends BaseController
{
    public function homeAction()
    {
        if (!empty($_SESSION['user_id']))
        {
            $manager = UserManager::getInstance();
            $user = $manager->getUserById($_SESSION['user_id']);
            $articles = ArticleManager::getInstance();
            $AllUsersArticles = $articles->AllUsersArticles();
            echo $this->renderView('home.html.twig',
                                   ['name' => $user['username'], 'AllUsersArticles' => $AllUsersArticles]);
        }
        else
            $this->redirect('login');
    }


    public function personnagesAction()
    {
        if (!empty($_SESSION['user_id']))
            echo $this->renderView('personnages.html.twig');
        else
            $this->redirect('login');
    }

    public function articlesAction()
    {
        if (!empty($_SESSION['user_id']))
            echo $this->renderView('articles.html.twig');
        else
            $this->redirect('login');
    }

    public function saisonAction()
    {
        if (!empty($_SESSION['user_id']))
            echo $this->renderView('saison.html.twig');
        else
            $this->redirect('login');
    }

}
