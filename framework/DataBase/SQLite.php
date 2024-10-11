<?php

namespace framework\DataBase;

require_once("config.php");

class SQLite {
    private $pdo;
    private $table;
    private $whereClauses = [];
    private $queryParams = [];
    private $dbName;

    public function __construct($dbName=null) {
        if(strtolower($dbName)=="null"){
            echo "db is empty";
            return;
        }
        if(!$this->createDatabase($dbName)){
        $this->dbName = $dbName.".sqlite";
        $this->connect();
    }
    }

    private function connect() {
        $dsn = "sqlite:" . __DIR__ . "/sqlite/" . $this->dbName;
        $this->pdo = new \PDO($dsn);
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

    // Function to create a new database
    public function createDatabase($dbName) {
        $dbName .= ".sqlite";
        $newDbPath = __DIR__ . "/sqlite/" . $dbName;
        if (file_exists($newDbPath)) {
            return false;
        }
        
        // Create an empty database file
        $handle = fopen($newDbPath, 'w');
        if (!$handle) {
            throw new \Exception("Could not create database file '$dbName'.");
        }
        fclose($handle);

        // Connect to the new database
        $this->dbName = $dbName;
        $this->connect();
        return true;
    }

    // Function to create a table
    public function createTable($tableName, $columns) {
        $columnsSql = implode(', ', $columns);
        $sql = "CREATE TABLE IF NOT EXISTS $tableName ($columnsSql)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    // Function to alter a table
    public function alterTable($tableName, $alteration) {
        $sql = "ALTER TABLE $tableName $alteration";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    // Function to drop a table
    public function dropTable($tableName) {
        $sql = "DROP TABLE IF EXISTS $tableName";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    // Function to drop the database
    public function dropDatabase() {
        $dbFile = __DIR__ . "/sqlite/" . $this->dbName;
        $this->dbName ="";
        return unlink($dbFile); // Deletes the database file
    }
}
