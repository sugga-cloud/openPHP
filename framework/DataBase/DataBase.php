<?php

namespace framework\DataBase;

require_once("../../config.php");

class Database {
    private $pdo;
    private $table;
    private $whereClauses = [];
    private $queryParams = [];

    public function __construct() {
        $dsn = "mysql:host=".$_ENV['DB_HOST'].";dbname=".$_ENV['DB_NAME'].";charset=utf8";
        $this->pdo = new \PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function table($table) {
        $this->table = $table;
        return $this;
    }

    public function where($column, $operator, $value) {
        $this->whereClauses[] = "$column $operator ?";
        $this->queryParams[] = $value;
        return $this;
    }

    public function get() {
        $sql = "SELECT * FROM $this->table";
        
        if (!empty($this->whereClauses)) {
            $sql .= " WHERE " . implode(' AND ', $this->whereClauses);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->queryParams);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id) {
        return $this->where('id', '=', $id)->get()[0] ?? null;
    }

    public function insert($data) {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));
        return $this->pdo->lastInsertId();
    }

    public function update($data) {
        $setClause = implode(',', array_map(fn($key) => "$key = ?", array_keys($data)));
        $sql = "UPDATE $this->table SET $setClause";
        
        if (!empty($this->whereClauses)) {
            $sql .= " WHERE " . implode(' AND ', $this->whereClauses);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_merge(array_values($data), $this->queryParams));
        return $stmt->rowCount();
    }

    public function delete() {
        $sql = "DELETE FROM $this->table";

        if (!empty($this->whereClauses)) {
            $sql .= " WHERE " . implode(' AND ', $this->whereClauses);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->queryParams);
        return $stmt->rowCount();
    }

    public function reset() {
        $this->whereClauses = [];
        $this->queryParams = [];
        return $this;
    }
}
