<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ArticleManager;
use App\Model\WishlistManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    // /home/index => /
    public function index()
    {
        $articleManager = new ArticleManager();
        $articles = $articleManager->selectAll();
        return $this->twig->render('Home/index.html.twig', [
            'articles' => $articles
        ]);
    }

    public function like(int $idArticle)
    {
        $wishManager = new WishlistManager();
        $isLiked = $wishManager->isLikedByUser($idArticle, $_SESSION['user']['id']);
        if (!$isLiked) {
            $wish = [
                'user_id' => $_SESSION['user']['id'],
                'article_id' => $idArticle
            ];
            $wishManager->insert($wish);
        }
        header('Location: /article/index');
    }

    public function dislike(int $idWish)
    {
        $wishManager = new WishlistManager();
        $wishManager->delete($idWish);
        header('Location: /user/account');
    }
}
