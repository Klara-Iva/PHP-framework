<?php

namespace Src\Models;

class User extends Model
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
        $this->enableSoftDeletes($this->db->getPdo());
        $this->enableTimestamps($this->db->getPdo());
    }
}