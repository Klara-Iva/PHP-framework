<?php

namespace Src\Models;

use Exception;
use Src\Database\Connection;
use PDO;

class Model
{
    protected $db;
    protected $pdo;
    protected $table;
    public $primaryKeyName;
    protected $id = null;
    protected $attributes = [];

    public function __construct()
    {
        $this->db = Connection::getInstance();
        $this->pdo = $this->db->getPdo();
        $this->primaryKeyName = $this->getPrimaryKey();
    }

    public function save()
    {
        if (!isset($this->id)) {
            $this->id = $this->db->insert($this->table, $this->attributes);
            $this->attributes[$this->primaryKeyName] = $this->id;
        } else {
            $this->db->update($this->table, $this->attributes, [$this->primaryKeyName => $this->id]);
        }
    }

    public function update()
    {
        if (is_null($this->id)) {
            throw new Exception('Cannot update record without primary key being set what ID it should use.');
        }
        $this->db->update($this->table, $this->attributes, [$this->primaryKeyName => $this->id]);
    }

    public static function find(string $primaryKeyValue)
    {
        $db = Connection::getInstance();
        $instance = new static();
        $query = "SELECT * FROM {$instance->table} WHERE {$instance->primaryKeyName} = :primaryKey LIMIT 1";
        $result = $db->fetchAssoc($query, ['primaryKey' => $primaryKeyValue]);

        if ($result) {
            echo 'The requested ID was found in the database' . PHP_EOL;
            $instance->attributes = $result;
            $instance->id = $result[$instance->primaryKeyName];
            return $instance;
        }

        return null;
    }

    public function toArray()
    {
        return $this->attributes;
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function getPrimaryKey(): string
    {
        $query = "SELECT COLUMN_NAME 
                  FROM INFORMATION_SCHEMA.COLUMNS 
                  WHERE TABLE_SCHEMA = DATABASE() 
                  AND TABLE_NAME = :table 
                  AND COLUMN_KEY = 'PRI'";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['table' => $this->table]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && isset($result['COLUMN_NAME'])) {
            return $result['COLUMN_NAME'];
        }

        throw new Exception('Primary key not found.');
    }

}