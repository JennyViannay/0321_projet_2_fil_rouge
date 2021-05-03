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
            return json_encode('true');
        }
        return json_encode('false');
        //header('Location: /article/index');
    }

    public function dislike(int $idWish)
    {
        $wishManager = new WishlistManager();
        $wishManager->delete($idWish);
        //header('Location: /user/account');
        return json_encode('true');
    }

    public function addToCart(int $idArticle)
    {
        if (!empty($_SESSION['cart'][$idArticle])) {
            $_SESSION['cart'][$idArticle]++;
        } else {
            $_SESSION['cart'][$idArticle] = 1;
        }
        // header('Location: /home/cart');
        return json_encode('true');
    }

    public function deleteFromCart(int $idArticle)
    {
        $cart = $_SESSION['cart'];
        if (!empty($cart[$idArticle])) {
            unset($cart[$idArticle]);
        }
        $_SESSION['cart'] = $cart;
        //header('Location: /home/cart');
        return json_encode('true');
    }

    public function getCartInfos()
    {
        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
            $cartInfos = [];
            $articleManager = new ArticleManager();
            foreach ($cart as $idArticle => $qty) {
                $article = $articleManager->selectOneById($idArticle);
                $article['qty'] = $qty;
                $cartInfos[] = $article;
            }
            return $cartInfos;
        }
        return false;
    }

}
