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
        $wishManager = new WishlistManager();
        $wishManager->delete($idWish);
        header('Location: /user/account');
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
            if (empty($data['firstname'])) {
                $errors['firstname'] = "Le champs firstname est requis";
            }
            if (empty($data['lastname'])) {
                $errors['lastname'] = "Le champs lastname est requis";
            }
            if (empty($data['subject'])) {
                $errors['subject'] = "Le champs subject est requis";
            }
            if (empty($data['message'])) {
                $errors['message'] = "Le champs message est requis";
            }
            if (empty($errors)) {
                $contactManager = new ContactManager();
                $contact = [
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'subject' => $data['subject'],
                    'message' => $data['message'],
                ];
                $contactManager->insert($contact);
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


}
