<?php

namespace App\Controller;

use App\Model\ArticleManager;
use App\Model\CategorieManager;
use App\Model\ContactManager;

class AdminController extends AbstractController
{
    /**
     * Route /admin/index
     */
    public function index()
    {
        if (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 1) {
            $articleManager = new ArticleManager();
            $articles = $articleManager->selectAll();

            $contactManager = new ContactManager();
            $contacts = $contactManager->selectAll();

            $categorieManager = new CategorieManager();
            $categories = $categorieManager->selectAll();

            return $this->twig->render('Admin/index.html.twig', [
                'articles' => $articles,
                'contacts' => $contacts,
                'categories' => $categories,
            ]);
        } else {
            header('Location: /');
        }
    }

    // ADD ENTITY

    /**
     * Route /admin/addArticle
     */
    public function addArticle()
    {
        if (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 1) {
            $categorieManager = new CategorieManager();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $articleManager = new ArticleManager();
                $article = [
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'price' => $_POST['price'],
                    'hours' => $_POST['hours'],
                    'image' => $_POST['image'],
                    'categorie_id' => $_POST['categorie_id'],
                ];
                $id = $articleManager->insert($article);
                header('Location:/article/show/' . $id);
            }

            return $this->twig->render('Article/add.html.twig', ['categories' => $categorieManager->selectAll()]);
        } else {
            header('Location: /');
        }
    }

    /**
     * Route /admin/addCategorie
     */
    public function addCategorie()
    {
        if (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 1) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $categorieManager = new CategorieManager();
                $categorie = [
                    'name' => $_POST['name'],
                ];
                $id = $categorieManager->insert($categorie);
                header('Location:/categorie/show/' . $id);
            }

            return $this->twig->render('Categorie/add.html.twig');
        } else {
            header('Location: /');
        }
    }

    // EDIT ENTITY

    /**
     * Route /admin/editArticle
     */
    public function editArticle(int $id)
    {
        if (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 1) {
            $articleManager = new ArticleManager();
            $article = $articleManager->selectOneById($id);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $article['title'] = $_POST['title'];
                $article['description'] = $_POST['description'];
                $article['price'] = $_POST['price'];
                $article['hours'] = $_POST['hours'];
                $article['image'] = $_POST['image'];
                $article['categorie_id'] = $_POST['categorie_id'];
                $articleManager->update($article);
            }
            return $this->twig->render('Article/edit.html.twig', ['article' => $article]);
        } else {
            header('Location: /');
        }
    }

    /**
     * Route /admin/editCategorie
     */
    public function editCategorie(int $id): string
    {
        if (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 1) {
            $categorieManager = new CategorieManager();
            $categorie = $categorieManager->selectOneById($id);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $categorie['name'] = $_POST['name'];
                $categorieManager->update($categorie);
            }

            return $this->twig->render('Categorie/edit.html.twig', ['categorie' => $categorie]);
        } else {
            header('Location: /');
        }
    }

    // DELETE ENTITY

    /**
     * Route /admin/deleteArticle/{param}
     */
    public function deleteArticle(int $id)
    {
        if (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 1) {
            $articleManager = new ArticleManager();
            $articleManager->delete($id);
            header('Location:/article/index');
        } else {
            header('Location: /');
        }
    }

    /**
     * Route /admin/deleteCategorie/{param}
     */
    public function deleteCategorie(int $id)
    {
        $categorieManager = new CategorieManager();
        $categorieManager->delete($id);
        header('Location:/categorie/index');
    }

    /**
     * Route /admin/deleteContact/{param}
     */
    public function deleteContact(int $id)
    {
        if (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 1) {
            $contactManager = new ContactManager();
            $contactManager->delete($id);
            header('Location:/admin/index');
        } else {
            header('Location: /');
        }
    }
}
