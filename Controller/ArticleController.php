<?php

namespace Controller;

use Model\ArticleManager;
use Model\UserManager;

class ArticleController extends BaseController
{
    public function add_articleAction()
    {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $manager = ArticleManager::getInstance();
            if (!empty($manager->userCheckArticle($_POST)))
            {
                $manager->userInsertArticle($manager->userCheckArticle($_POST));
            }
            else{
                $error = "Invalid username or password";
            }
        }
        echo $this->renderView('add_article.html.twig', ['error' => $error]);
    }
}
