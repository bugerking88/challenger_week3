<?php

class PDOConnect
{
    protected $db;

    public function __construct()
    {
        $dsn="mysql:host=localhost;dbname=ReadSoccerData;port=3306;charset=utf8";
        $this->db = new PDO("$dsn", "root", "");
    }
}
