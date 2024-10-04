<?php

namespace Src\Database;

use PDO;
use PDOException;

class Connection
{
    private static $instance = null;
    public $pdo;
   
    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=php-frameworkDB';
        $username = 'root';
        $password = '';

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connection to databse successful" . PHP_EOL;
        } catch (PDOException $e) {
            echo "Connection to  database failed: " . $e->getMessage();
        }   

    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function fetchAssoc(string $query, array $params)
    {
        // this doesnt work if associative array is specifically like: $params = [0 => "sun",1 => "moon",2 => "pluto"];
        $stmt = $this->checkIfAssociative($query, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAssocAll(string $query, array $params)
    {
        $limitPattern = '/LIMIT\s+(\d+)(?:,\s*(\d+))?/i'; // "LIMIT 10, 5" ->return 10 results with offset 5
        if (preg_match($limitPattern, $query, $matches)) {
            $limitCount = isset($matches[1]) ? (int) $matches[1] : 0; // rounding it to int or 0 if doesnt exist
            $offset = isset($matches[2]) ? (int) $matches[2] : 0;
        } else {
            $limitCount = 0;
            $offset = 0;
        }

        if ($limitCount === 0) {
            // limit doesnt exist, return all->potential high memory usage
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->checkIfAssociative($query, $params);
            $results = [];
            $currentCount = 0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $results[] = $row;
                if ($currentCount >= $offset) {
                    $results[] = $row;
                }
                $currentCount++;
                if (count($results) >= $limitCount) {
                    break;
                }

            }

            return $results;
        }

    }

    public function insert(string $table, array $data)
    {
        if (!empty($data)) {
            $isAssociative = $this->areAssociativeArrays($data);
            if ($isAssociative) {
                foreach ($data as $array) {
                    $this->executeQuery($table, $array);
                }

            } else {
                $this->executeQuery($table, $data);
            }

            return $this->pdo->lastInsertId();
        }

        return null;
    }

    public function update(string $table, array $data, array $conditions)
    {
        if (!empty($data) && !empty($conditions)) {
            $setColumns = [];
            foreach ($data as $key => $value) {
                $setColumns[] = "$key = :$key";
            }

            $setClause = implode(", ", $setColumns);
            $conditionFields = [];
            foreach ($conditions as $key => $value) {
                $conditionFields[] = "$key = :cond_$key";
            }

            $conditionClause = implode(" AND ", $conditionFields);
            $query = "UPDATE $table SET $setClause WHERE $conditionClause"; //in sql terms: "UPDATE products SET price = :price, name = :name WHERE id = :cond_id"
            $stmt = $this->pdo->prepare($query);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":cond_$key", $value);
            }

            $stmt->execute();
        }

    }

    public function checkIfAssociative(string $query, array $params)
    {
        $isAssociativeArray = array_keys($params) !== range(0, count($params) - 1);
        $stmt = $this->pdo->prepare($query);

        if ($isAssociativeArray) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->execute($params);
        } else {
            $stmt->execute($params);
        }

        return $stmt;
    }

    public function executeQuery(string $table, array $data)
    {
        $fields = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $query = "INSERT INTO $table ($fields) VALUES ($placeholders)";

        $stmt = $this->pdo->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
    }

    public function areAssociativeArrays(array $arrays): bool
    {
        foreach ($arrays as $array) {
            if (!is_array($array) || !(array_keys($array) !== range(0, count($array) - 1))) {
                return false;
            }

        }

        return true;
    }

}