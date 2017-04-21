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
        $AllUsernames = array();
        foreach($AllUsersArticles as $article){
            $user = $manager->getUserById((int)$article['user_id']);
            $AllUsernames[(int)$article['user_id']] = $user['username'];
        }
        echo $this->renderView('home.html.twig',
                                   ['AllUsersArticles' => $AllUsersArticles, 'AllUsernames'=>$AllUsernames]);
    }


    public function profilAction()
    {
        if (!empty($_SESSION['user_id']))
            echo $this->renderView('profil.html.twig');
        else
            $this->redirect('login');
    }

    public function articlesAction()
    {
        $articles = ArticleManager::getInstance();
        $AllUsersArticles = $articles->AllUsersArticles();
        echo $this->renderView('articles.html.twig',
                                    ['AllUsersArticles' => $AllUsersArticles]);
    }
    public function read_articleAction()
    {
        $articles = ArticleManager::getInstance();
        $AllUsersArticles = $articles->AllUsersArticles();
        echo $this->renderView('read_article.html.twig',
            ['AllUsersArticles' => $AllUsersArticles]);
    }


    public function saisonAction()
    {
        if (!empty($_SESSION['user_id']))
            echo $this->renderView('saison.html.twig');
        else
            $this->redirect('login');
    }

}
