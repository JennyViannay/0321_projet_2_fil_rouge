<?php

namespace App\Controller;

use App\Model\WishlistManager;
use App\Service\CartService;

class AjaxController extends AbstractController
{
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
            return json_encode(true);
        }
        return json_encode(false);
    }

    public function addToCart(int $idArticle)
    {
        if (!empty($_SESSION['cart'][$idArticle])) {
            $_SESSION['cart'][$idArticle]++;
        } else {
            $_SESSION['cart'][$idArticle] = 1;
        }
        return json_encode(true);
    }

    public function totalCart()
    {
        $cartService = new CartService();
        $total = 0;
        if ($cartService->getCartInfos() != false) {
            foreach ($cartService->getCartInfos() as $article) {
                $total += $article['price'] * $article['qty'];
            }
        }
        return json_encode($total, 200);
    }

}
