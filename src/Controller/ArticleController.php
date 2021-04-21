<?php

namespace App\Controller;

use App\Model\ArticleManager;
use App\Model\CategorieManager;

class ArticleController extends AbstractController
{
    public function index()
    {
        $articleManager = new ArticleManager();
        $articles = $articleManager->selectAll();

        return $this->twig->render('Article/index.html.twig', ['articles' => $articles]);
    }

    public function show(int $id)
    {
        return $this->twig->render('Article/show_article.html.twig');
    }
}
