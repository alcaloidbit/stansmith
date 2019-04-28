<?php

namespace StanSmith\Core\Repository;

use \PDO;

class AlbumRepository
{
    private $connection;

    public function __construct(PDO $connection = null)
    {
        $dsn = 'mysql:host='._DB_HOST_.';dbname='._DB_NAME_.'';
        $this->connection = $connection;

        if ($this->connection === null) {
            $this->connection = new PDO(
                $dsn, _DB_USER_, _DB_PASSWD_
            );
        };

        $this->connection->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );
    }


    public function find($id_album)
    {
        $stmt = $this->connection->prepare('
            SELECT * from `album`
            WHERE `id_album` = :id_album
        ');
        
        $stmt->bindParam(':id_album', $id_album);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, '\StanSmith\Core\Model\AlbumModel');
        $object = $stmt->fetch();
        return $object;
    }

    
    public function findAll($order_by='id_album', $order_way='DESC', $start=0, $limit=12)
    {
        $stmt = $this->connection->prepare('
            SELECT * FROM `album` WHERE `deleted` IS NULL 
            ORDER BY `'.$order_by.'` '.$order_way.'
            LIMIT '.$start.', '.$limit.' 
        ');

        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, '\StanSmith\Core\Model\AlbumModel');
        $arrayOfObject = $stmt->fetchAll();
        return $arrayOfObject;
    }
}



