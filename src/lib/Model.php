<?php

namespace User\Instagram\lib;

class Model{

    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function prepare($query): bool|\PDOStatement
    {
        return $this->db->connect()->prepare($query);
    }

    public function query($query): bool|\PDOStatement
    {
        return $this->db->connect()->query($query);
    }
}