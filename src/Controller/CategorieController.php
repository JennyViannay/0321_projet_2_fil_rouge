<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\CategorieManager;

/**
 * Class CategorieController
 *
 */
class CategorieController extends AbstractController
{
    /**
     * Display categorie listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $categorieManager = new CategorieManager();
        $categories = $categorieManager->selectAll();

        return $this->twig->render('Categorie/index.html.twig', ['categories' => $categories]);
    }


    /**
     * Display categorie informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $categorieManager = new CategorieManager();
        $categorie = $categorieManager->selectOneById($id);

        return $this->twig->render('Categorie/show.html.twig', ['categorie' => $categorie]);
    }


    /**
     * Display categorie edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $categorieManager = new CategorieManager();
        $categorie = $categorieManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categorie['name'] = $_POST['name'];
            $categorieManager->update($categorie);
        }

        return $this->twig->render('Categorie/edit.html.twig', ['categorie' => $categorie]);
    }


    /**
     * Display categorie creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categorieManager = new CategorieManager();
            $categorie = [
                'name' => $_POST['name'],
            ];
            $id = $categorieManager->insert($categorie);
            header('Location:/categorie/show/' . $id);
        }

        return $this->twig->render('Categorie/add.html.twig');
    }


    /**
     * Handle categorie deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $categorieManager = new CategorieManager();
        $categorieManager->delete($id);
        header('Location:/categorie/index');
    }
}
