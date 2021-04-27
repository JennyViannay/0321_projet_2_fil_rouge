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
use App\Model\OrderArticleManager;
use App\Model\OrderManager;
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

    public function order()
    {
        $orderManager = new OrderManager();
        $orderArticleManager = new OrderArticleManager();
        $articleManager = new ArticleManager();
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if (!empty($_POST['address'])) {
                $order = [
                    'created_at' => date('y-m-d'),
                    'total' => $this->totalCart(),
                    'user_id' => $_SESSION['user']['id'],
                    'address' => $_POST['address'],
                ];
                $idOrder = $orderManager->insert($order);
                
                if ($idOrder) {
                    foreach($_SESSION['cart'] as $idArticle => $qty) {
                        // $article = $articleManager->selectOneById($idArticle);
                        // $newQty = $article['qty'] - $qty;
                        // $articleManager->updateQty($idArticle, $newQty);
                        $newLineInTickets = [
                            'order_id' => $idOrder,
                            'article_id' => $idArticle,
                            'qty' => $qty,
                        ];
                        $orderArticleManager->insert($newLineInTickets);
                    }
                    unset($_SESSION['cart']);
                    header('Location: /');
                }
            }
        }
        return $this->twig->render('Home/order.html.twig');
    }

    public function orderDetail(int $orderId)
    {
        $orderArticleManager = new OrderArticleManager();
        $articleManager = new ArticleManager();

        $ticket = $orderArticleManager->getTicketFromOrderId($orderId);

        $result = [];
        foreach($ticket as $detail)
        {
            $article = $articleManager->selectOneById($detail['article_id']);
            $detail['article_id'] = $article;
            
            $result[] = $detail;
        }
        return $this->twig->render('Order/detail.html.twig', [
            'ticket' => $result,
            'orderId' => $orderId,
        ]);
        
    }
}


// ORDER 

// TICKET DE CAISSE  ~ GESTION DE STOCK

// CLEAR PANIER & REDIRECT SUCCESS 

// ENVOIE D'email avec ORDER ID + TICKET DE CAISSE 