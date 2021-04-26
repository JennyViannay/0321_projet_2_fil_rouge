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

    public function selectAll(): array
    {
        return $this->pdo->query('SELECT * FROM `order` ORDER BY id DESC')->fetchAll();
    }

    /**
     * @param array $order
     * @return int
     */
    public function insert(array $order): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO `order` (`created_at`, `total`, `user_id`, `address`) 
        VALUES (:created_at, :total, :user_id, :address)");
        $statement->bindValue('created_at', $order['created_at']);
        $statement->bindValue('total', $order['total'], \PDO::PARAM_INT);
        $statement->bindValue('user_id', $order['user_id'], \PDO::PARAM_INT);
        $statement->bindValue('address', $order['address'], \PDO::PARAM_STR);

        $statement->execute();
        return (int) $this->pdo->lastInsertId();
    }
}
