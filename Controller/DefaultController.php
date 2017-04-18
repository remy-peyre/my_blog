<?php

namespace Controller;

use Model\UserManager;

class DefaultController extends BaseController
{
    public function homeAction()
    {
        if (!empty($_SESSION['user_id']))
        {
            $manager = UserManager::getInstance();
            $user = $manager->getUserById($_SESSION['user_id']);
            
            echo $this->renderView('home.html.twig',
                                   ['name' => $user['username']]);
        }
        else
            $this->redirect('login');
    }

    /*public function aboutAction()
    {
        if (!empty($_SESSION['user_id']))
            echo $this->renderView('about.html.twig');
        else
            $this->redirect('login');
    }*/
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
