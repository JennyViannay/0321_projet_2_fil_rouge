<?php

namespace App\Controller;

use App\Model\ArticleManager;

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
        $articleManager = new ArticleManager();
        $article = $articleManager->selectOneById($id);

        return $this->twig->render('Article/show.html.twig', ['article' => $article]);
    }

    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $articleManager = new ArticleManager();
            $articles = $articleManager->searchByTitle($_POST['title']);
            
            return $this->twig->render('Article/index.html.twig', ['articles' => $articles]);
        }
    }
}
