<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ArticleManager;
use App\Model\ContactManager;
use App\Model\WishlistManager;
use DateTime;

class HomeController extends AbstractController
{
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
        // TODO :: DELETE FROM WISHLIST
    }

    public function cart()
    {
        $cartInfos = $this->getCartInfos();
        $totalCart = $this->totalCart();
        return $this->twig->render('Home/cart.html.twig', [
            'cart' => $cartInfos,
            'totalCart' => $totalCart,
        ]);
    }

    public function addToCart(int $idArticle)
    {
        if (!empty($_SESSION['cart'][$idArticle])) {
            $_SESSION['cart'][$idArticle]++;
        } else {
            $_SESSION['cart'][$idArticle] = 1;
        }
        header('Location: /home/cart');
    }

    public function deleteFromCart(int $idArticle)
    {
        $cart = $_SESSION['cart'];
        if (!empty($cart[$idArticle])) {
            unset($cart[$idArticle]);
        }
        $_SESSION['cart'] = $cart;
        header('Location: /home/cart');
    }

    public function totalCart()
    {
        $total = 0;
        if ($this->getCartInfos() != false) {
            foreach ($this->getCartInfos() as $article) {
                $total += $article['price'] * $article['qty'];
            }
            return $total;
        }
        return $total;
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

    public function contact()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $data = array_map('trim', $_POST);
            // TODO :: GESTION D'ERREURS POUR CHAQUE CHAMPS  
            if (empty($errors)) {
                $contactManager = new ContactManager();
                $contact = [
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'subject' => $data['subject'],
                    'message' => $data['message'],
                ];
                $contactManager->insert($contact);
                // TODO :: ENVOYER LES INFOS DU FORMULAIRE SUR LA PAGE SUCCESS ET LES AFFICHER
                header('Location: /home/success');
            }
        }
        return $this->twig->render('Home/contact.html.twig', [
            'errors' => $errors
        ]);
    }

    public function success()
    {
        return $this->twig->render('Home/success.html.twig');
    }

    public function order()
    {
        // TODO :: ORDER AND TICKETS
        return $this->twig->render('Home/order.html.twig');
    }
}
