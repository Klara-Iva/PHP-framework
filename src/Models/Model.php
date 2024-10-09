<?php

namespace Src\Models;

use Exception;
use Src\Database\Connection;
use PDO;
use DateTime;
use Src\Traits\HasTimestamps;
use Src\Traits\HasSoftDeletes;

class Model
{
    use HasTimestamps, HasSoftDeletes;
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
        if ($this->timestampsEnabled) {
            $this->setTimestamps($this->attributes);
        }

        if (!isset($this->id)) {
            $this->id = $this->db->insert($this->table, $this->attributes);
            $this->attributes[$this->primaryKeyName] = $this->id;
            echo "Item saved with ID: " . $this->id . PHP_EOL;
        } else {
            $this->db->update($this->table, $this->attributes, [$this->primaryKeyName => $this->id]);
        }

    }

    public function update(string $id)
    {
        if (is_null($this->id)) {
            throw new Exception('Cannot update record without primary key being set what ID it should use.');
        }

        if ($this->timestampsEnabled) {
            $now = (new DateTime())->format('Y-m-d H:i:s');
            $this->attributes['updated_at'] = $now;
        }

        $this->db->update($this->table, $this->attributes, [$this->primaryKeyName => $this->id]);
        echo 'Item with ID ' . $this->id . 'updated.' . PHP_EOL;
    }

    public static function find(string $primaryKeyValue)
    {
        $db = Connection::getInstance();
        $instance = new static();
        $query = "SELECT * FROM {$instance->table} WHERE {$instance->primaryKeyName} = :primaryKey LIMIT 1";
        $result = $db->fetchAssoc($query, ['primaryKey' => $primaryKeyValue]);

        if ($result) {
            $instance->attributes = $result;
            $instance->id = $result[$instance->primaryKeyName];
            return $instance;
        }

        return null;
    }

    public function delete(string $id)
    {
        $this->id = $id;
        if (is_null($this->id)) {
            throw new Exception("Cannot delete record without a primary key value.");
        }

        if ($this->softDeletesEnabled) {
            $this->softDelete($id);
        } else {
            $query = "DELETE FROM {$this->table} WHERE {$this->primaryKeyName} = :primaryKey LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':primaryKey', $this->id);
            $stmt->execute();
            echo 'Item with ID ' . $this->id . ' deleted.' . PHP_EOL;
            if ($stmt->rowCount() > 0) {
                return true;
            }

        }

        return false;
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