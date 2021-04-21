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
class ContactManager extends AbstractManager
{
    public const TABLE = 'contact';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAll(): array
    {
        return $this->pdo->query('SELECT * FROM ' . self::TABLE . '
        ORDER BY id DESC')->fetchAll();
    }

    /**
     * @param array $article
     * @return int
     */
    public function insert(array $article): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        " (`firstname`, `lastname`, `subject`, `message`) 
        VALUES (:firstname, :lastname, :subject, :message)");
        $statement->bindValue('firstname', $article['firstname'], \PDO::PARAM_STR);
        $statement->bindValue('lastname', $article['lastname'], \PDO::PARAM_STR);
        $statement->bindValue('subject', $article['subject'], \PDO::PARAM_STR);
        $statement->bindValue('message', $article['message'], \PDO::PARAM_STR);

        $statement->execute();
        return (int) $this->pdo->lastInsertId();
    }


    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
