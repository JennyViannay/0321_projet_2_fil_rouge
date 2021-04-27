<?php

namespace App\Model;

use PDO;

class OrderManager extends AbstractManager
{
    public const TABLE = 'order';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert(array $order)
    {
        $statement = $this->pdo->prepare("INSERT INTO `order` (created_at, total, user_id, address) 
        VALUES (:created_at, :total, :user_id, :address)");
        $statement->bindValue('created_at', $order['created_at'], PDO::PARAM_STR);
        $statement->bindValue('total', $order['total'], PDO::PARAM_INT);
        $statement->bindValue('user_id', $order['user_id'], PDO::PARAM_INT);
        $statement->bindValue('address', $order['address'], PDO::PARAM_STR);

        $statement->execute();

        return (int) $this->pdo->lastInsertId();
    }

    public function getOrdersByUser(int $idUser)
    {
        $statement = $this->pdo->prepare("SELECT * FROM `order` WHERE user_id= :user_id");
        $statement->bindValue('user_id', $idUser, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll();
    }
}