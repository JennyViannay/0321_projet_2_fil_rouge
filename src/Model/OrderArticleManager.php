<?php

namespace App\Model;

use PDO;

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

    public function insert(array $order)
    {
        $statement = $this->pdo->prepare("INSERT INTO `order_article` (order_id, article_id, qty) 
        VALUES (:order_id, :article_id, :qty)");
        $statement->bindValue('order_id', $order['order_id'], PDO::PARAM_INT);
        $statement->bindValue('article_id', $order['article_id'], PDO::PARAM_INT);
        $statement->bindValue('qty', $order['qty'], PDO::PARAM_INT);

        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }

    public function getTicketFromOrderId(int $orderId)
    {
        $statement = $this->pdo->prepare("SELECT * FROM `order_article` WHERE order_id= :order_id");
        $statement->bindValue('order_id', $orderId, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll();
    }
}