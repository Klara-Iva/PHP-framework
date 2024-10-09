<?php

namespace Src\Models;

class Product extends Model
{
    protected $table = 'products';

    public function __construct()
    {
        parent::__construct();
        $this->enableTimestamps($this->db->getPdo());
    }

}