<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\ArticleManager;
use App\Model\CategorieManager;

/**
 * Class ArticleController
 *
 */
class ArticleController extends AbstractController
{
    /**
     * Display article listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $articleManager = new ArticleManager();
        $articles = $articleManager->selectAll();

        return $this->twig->render('Article/index.html.twig', ['articles' => $articles]);
    }


    /**
     * Display article informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $articleManager = new ArticleManager();
        $article = $articleManager->selectOneById($id);

        return $this->twig->render('Article/show.html.twig', ['article' => $article]);
    }


    /**
     * Display article edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
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
    }


    /**
     * Display article creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
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
    }


    /**
     * Handle article deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $articleManager = new ArticleManager();
        $articleManager->delete($id);
        header('Location:/article/index');
    }
}
