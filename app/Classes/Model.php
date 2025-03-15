<?php

namespace App\Classes;

use Psr\Container\ContainerInterface;

abstract class Model
{
    protected string $table;
    protected string $pk = "id";
    protected Db $db;
    protected string $model;

    public function __construct()
    {
        $this->db = Db::instance();
        $this->model = get_class($this);
    }

    public function fetch(string $sql, array $params = [], string $model = "")
    {
        $model = ($model === "") ? $this->model : $model;
        return Db::fetch($sql, $params, $model);
    }

    public function find(int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->pk} = :id LIMIT 1;";
        $params = [":id" => $id];
        return $this->fetch($sql, $params) === [] ? null : $this->fetch($sql, $params)[0];
    }
}
