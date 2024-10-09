<?php
namespace Src\Traits;

use PDO;

trait HasSoftDeletes
{
    protected $softDeletesEnabled = false;

    public function enableSoftDeletes(PDO $db)
    {
        $this->softDeletesEnabled = true;

        $tableName = $this->table;
        $columns = $db->prepare("SHOW COLUMNS FROM $tableName");
        $columns->execute();
        $existingColumns = $columns->fetchAll(PDO::FETCH_COLUMN);

        if (!in_array('deleted_at', $existingColumns)) {
            $addDeletedAt = $db->prepare("ALTER TABLE $tableName ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL");
            $addDeletedAt->execute();
        }
    }

    public function softDelete(string $id)
    {
        if (is_null($id)) {
            echo'Cannot soft delete record without primary key being set.' . PHP_EOL;
            return;
        }
        //TODO add check if item is already deleted, currently updates with every request
        $deletedAt = date('Y-m-d H:i:s');
        $this->db->update($this->table, ['deleted_at' => $deletedAt], [$this->primaryKeyName => $id]);
        echo 'Item deleted!' . PHP_EOL;
    }

    public function delete(string $id)
    {
        if (is_null($id)) {
            echo 'Cannot delete record without primary key being set.'. PHP_EOL;
            return;
        }

        $this->db->delete($this->table, [$this->primaryKeyName => $id]);
    }

}