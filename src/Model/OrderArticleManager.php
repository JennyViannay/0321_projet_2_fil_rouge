<?php

/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class OrderArticleManager extends AbstractManager
{
    public const TABLE = 'order_article';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAll(): array
    {
        return $this->pdo->query('SELECT * FROM `order_article` ORDER BY id DESC')->fetchAll();
    }

    /**
     * @param array $order
     * @return int
     */
    public function insert(array $order): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO `order_article` (`order_id`, `article_id`, `qty`) 
        VALUES (:order_id, :article_id, :qty)");
        $statement->bindValue('order_id', $order['order_id'], \PDO::PARAM_INT);
        $statement->bindValue('article_id', $order['article_id'], \PDO::PARAM_INT);
        $statement->bindValue('qty', $order['qty'], \PDO::PARAM_INT);

        $statement->execute();
        return (int) $this->pdo->lastInsertId();
    }
}