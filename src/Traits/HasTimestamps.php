<?php
namespace Src\Traits;

use DateTime;
use PDO;

trait HasTimestamps
{
    protected $timestampsEnabled = false;

    public function enableTimestamps(PDO $db)
    {
        $this->timestampsEnabled = true;

        $tableName = $this->table;
        $columns = $db->prepare("SHOW COLUMNS FROM $tableName");
        $columns->execute();
        $existingColumns = $columns->fetchAll(PDO::FETCH_COLUMN);

        if (!in_array('created_at', $existingColumns)) {
            $addCreatedAt = $db->prepare("ALTER TABLE $tableName ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
            $addCreatedAt->execute();
        }

        if (!in_array('updated_at', $existingColumns)) {
            $addUpdatedAt = $db->prepare("ALTER TABLE $tableName ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
            $addUpdatedAt->execute();
        }
        
    }

    public function setTimestampsEnabled(bool $enabled): void
    {
        $this->timestampsEnabled = $enabled;
    }

    protected function setTimestamps(array &$data): void
    {
        if ($this->timestampsEnabled) {
            $now = (new DateTime())->format('Y-m-d H:i:s');

            if (!isset($data['created_at'])) {
                $data['created_at'] = $now;
            }

            $data['updated_at'] = $now;
        }

    }

}