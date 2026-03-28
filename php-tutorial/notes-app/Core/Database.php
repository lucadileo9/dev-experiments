<?php

namespace Core;
use Core\Response;
use PDO; 

class Database {

    public $connection;
    public $statement;

    public function __construct($config, $user='root', $password='')
    {
        $dsn = "mysql:" . http_build_query($config, '', ';');

        //  dd( $dsn);
       
        // Vecchia versione hardcodata
        //  $dsn = "mysql:host=localhost;port=3306;dbname=myapp;charset=utf8mb4";
        //  dd( $dsn);

        $this->connection = new PDO($dsn, $user, $password);
    }
    
    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);
        return $this;
    }

    public function find()
    {
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOrFail()
    {
        $result = $this->find();
        if (!$result) {
            abort(Response::NOT_FOUND);
        }
        return $result;
    }
}
