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
            SELECT a.*, artist.`name` as artist_name 
            from `album` a left join artist
            on a.`id_artist` = artist.`id_artist`
            WHERE `id_album` = :id_album
        ');

        $stmt->bindParam(':id_album', $id_album);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, '\StanSmith\Core\Model\AlbumModel');
        $object = $stmt->fetch();
        $object->setSongs();
        $object->setImages();
        return $object;
    }

    public function findAll($order_by='id_album', $order_way='DESC', $start=0, $limit=12)
    {
        $stmt = $this->connection->prepare('
            SELECT a.*, artist.`name` as artist_name
            FROM `album` a left join artist 
            on a.`id_artist` = artist.`id_artist`
            WHERE a.`deleted` IS NULL
            ORDER BY a.`'.$order_by.'` '.$order_way.'
            LIMIT '.$start.', '.$limit.'
        ');

        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, '\StanSmith\Core\Model\AlbumModel');
        $arrayOfObject = $stmt->fetchAll();

        foreach($arrayOfObject as $obj) {
            $obj->setSongs();
            $obj->setImages(); 
        }
            
        return $arrayOfObject;
    }

}



