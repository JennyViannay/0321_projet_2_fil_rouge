<?php

namespace App\Controller;

use App\Model\ArticleManager;
use App\Model\OrderArticleManager;
use App\Model\OrderManager;
use App\Model\WishlistManager;

class UserController extends AbstractController
{
    public function account()
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            $wishManager = new WishlistManager();
            $articleManager = new ArticleManager();
            // wishlist article_id
            $wishlist = $wishManager->getWishlistByUser($_SESSION['user']['id']);
            $result = [];
            foreach ($wishlist as $wish) {
                $article = $articleManager->selectOneById($wish['article_id']);
                $result[] = ["wish_id" => $wish['id'], "article" => $article];
            }

            $orderManager = new OrderManager();
            $orders = $orderManager->getOrdersByUser($_SESSION['user']['id']);
            
            return $this->twig->render('User/account.html.twig', [
                'wishlist' => $result,
                'orders' => $orders,
            ]);
        }
        header('Location: /security/login');
    }
}
