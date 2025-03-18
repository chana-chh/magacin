<?php

namespace App\Classes;

use Psr\Container\ContainerInterface;

abstract class Model
{
    protected string $table;
    protected string $pk = "id";
    protected Db $db;
    protected string $model;
    protected array $pagination_config;

    public function __construct()
    {
        $this->db = Db::instance();
        $this->model = get_class($this);
        $this->pagination_config = Cfg::get('settings')['pagination'];
    }

    public function run(string $sql, ?array $params = null)
    {
        return Db::run($sql, $params);
    }

    public function fetch(string $sql, array $params = [], string $model = "")
    {
        $model = ($model === "") ? $this->model : $model;
        return Db::fetch($sql, $params, $model);
    }

    public function all(string $sort_column = 'id', $sort = 'ASC')
    {
        $order_by = '';
        $params = null;
        $sort = ($sort === 'DESC') ? $sort : 'ASC';
        if (!empty(trim($sort_column))) {
            $order_by = " ORDER BY :{$sort_column} {$sort}";
            $params = [":{$sort_column}" => $sort_column];
        }
        $sql = "SELECT * FROM {$this->table}{$order_by};";
        return $this->fetch($sql, $params);
    }

    public function find(int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->pk} = :id LIMIT 1;";
        $params = [":id" => $id];
        return $this->fetch($sql, $params) === [] ? null : $this->fetch($sql, $params)[0];
    }

    public function select(array $columns)
    {
        $cols = implode(', ', $columns);
        $sql = "SELECT {$cols} FROM {$this->table};";
        return $this->fetch($sql);
    }

    public function countTable()
    {
        $sql = "SELECT COUNT(*) AS table_count FROM {$this->table}";
        return (int)$this->fetch($sql)[0]->table_count;
    }

    public function insert(array $data)
    {
        $cols = implode(', ', array_keys($data));
        $vals = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO `{$this->table}` ({$cols}) VALUES ({$vals});";
        $success = $this->run($sql, array_values($data));
        return $success ? $this->db->getLastInsertedId() : false;
    }

    public function update(array $data, int $id)
    {
        $updates = [];
        $params = array_merge($data, ['id' => $id]);
        foreach ($data as $key => $value) {
            $updates[] = "{$key} = :{$key}";
        }
        $sql = "UPDATE `{$this->table}` SET " . implode(', ', $updates) . " WHERE id = :id;";
        return $this->run($sql, $params);
    }

    public function deleteOne(int $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->pk} = :{$this->pk}";
        $params = [":{$this->pk}" => $id];
        return $this->run($sql, $params);
    }

    public function delete(array $where)
    {
        list($column, $operator, $value) = $where;
        $sql = "DELETE FROM {$this->table} WHERE {$column} {$operator} :{$column};";
        $params = [":{$column}" => $value];
        return $this->run($sql, $params);
    }

    public function enumOrSetList($column)
    {
        $sql = "SELECT DATA_TYPE, COLUMN_TYPE
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE TABLE_NAME = :tn AND COLUMN_NAME = :cn;";
        $params = [':tn' => $this->table, ':cn' => $column];
        $result = $this->fetch($sql, $params)[0];
        if ($result->DATA_TYPE === 'enum' || $result->DATA_TYPE === 'set') {
            $list = explode(
                ",",
                str_replace(
                    "'",
                    "",
                    substr($result->COLUMN_TYPE, 5, (strlen($result->COLUMN_TYPE) - 6))
                )
            );
            if (is_array($list) && !empty($list)) {
                return $list;
            }
        } else {
            return null;
        }
    }

    public function paginate(int $page, ?string $sql = null, ?array $params = null, ?int $perpage = null, ?int $span = null)
    {
        $sql = ($sql !== null) ? $sql : "SELECT * FROM {$this->table};";
        $data = $this->pageData($page, $sql, $params, $perpage);
        $links = $this->pageLinks($page, $perpage, $span);
        return ['data' => $data, 'links' => $links];
    }

    protected function pageData(int $page, string $sql, ?array $params = null, ?int $perpage = null)
    {
        $sql = str_replace('SELECT', 'SELECT SQL_CALC_FOUND_ROWS', $sql);
        if ($perpage === null) {
            $perpage = $this->pagination_config['per_page'];
        }
        $limit = $perpage;
        $offset = ($page - 1) * $perpage;
        $sql = rtrim($sql, ';');
        $sql .= " LIMIT {$limit} OFFSET {$offset};";
        $data = $this->fetch($sql, $params);
        return $data;
    }

    protected function foundRows()
    {
        $sql = "SELECT FOUND_ROWS() AS count;";
        return (int)$this->fetch($sql)[0]->count;
    }

    // FIXME srediti URL
    protected function pageLinks(int $page, ?int $perpage = null)
    {
        $css = $this->pagination_config['css'];
        $links = [];
        $links['current_page'] = $page;
        if ($perpage === null) {
            $perpage = $this->pagination_config['per_page'];
        }
        $links['per_page'] = $perpage;
        $span = $this->pagination_config['page_span'];
        $count = $this->foundRows();
        $links['total_rows'] = $count;
        // $u = Config::getContainer('request')->getUri();
        // $url = $u->getBaseUrl() . '/' . $u->getPath();
        // $links['url'] = $url;
        $url="";
        $pages = (int)ceil($count / $perpage);
        $links['total_pages'] = $pages;
        $full_span = (($span * 2 + 1) > $pages) ? $pages : $span * 2 + 1;
        $prev = ($page > 2) ? $page - 1 : 1;
        $links['prev_page'] = $prev;
        $next = ($page < $pages) ? $page + 1 : $pages;
        $links['next_page'] = $next;
        $start = $page - $span;
        $end = $page + $span;
        if ($page <= $span + 1) {
            $start = 1;
            $end = $full_span;
        }
        if ($page >= $pages - $span) {
            $start = $pages - $span * 2;
            $end = $pages;
        }
        if ($full_span >= $pages) {
            $start = 1;
            $end = $pages;
        }
        $disabled_begin = ($page === 1) ? $css['button_disabled'] : "";
        $disabled_end = ($page === $pages) ? $css['button_disabled'] : "";
        $zapis_od = (($page - 1) * $perpage) + 1;
        $zapis_do = ($zapis_od + $perpage) - 1;
        $zapis_do = $zapis_do >= $count ? $count : $zapis_do;
        $links['row_from'] = $zapis_od;
        $links['row_to'] = $zapis_do;

        $buttons = "<ul class=\"{$css['buttons_container']}\">";
        $buttons .= "<li><a class=\"{$disabled_begin}\" href=\"{$url}?page=1\" tabindex=\"-1\">1</a></li>";
        $buttons .= "<li><a class=\"{$disabled_begin}\" href=\"{$url}?page={$prev}\" tabindex=\"-1\"><span uk-icon=\"chevron-left\"></span></a></li>";
        for ($i = $start; $i <= $end; $i++) {
            $current = '';
            if ($page === $i) {
                $current = $css['button_active'] . ' ' . $css['button_disabled'];
            }
            $buttons .= "<li><a class=\"{$current}\" href=\"{$url}?page={$i}\" tabindex=\"-1\">{$i}</a></li>";
        }
        $buttons .= "<li><a class=\"{$disabled_end}\" href=\"{$url}?page={$next}\" tabindex=\"-1\"><span uk-icon=\"chevron-right\"></span></a></li>";
        $buttons .= "<li><a class=\"{$disabled_end}\" href=\"{$url}?page={$pages}\" tabindex=\"-1\">{$pages}</a></li>";
        $buttons .= "</ul>";
        $links['buttons'] = $buttons;
        $goto = "<select class=\"{$css['goto']}\" name=\"pgn-goto\" id=\"pgn-goto\">";
        for ($i = 1; $i <= $pages; $i++) {
            $selected = '';
            if ($page === $i) {
                $selected = ' selected';
            }
            $goto .= "<option value=\"{$url}?page={$i}\"{$selected}>{$i}</option>";
        }
        $goto .= "</select>";
        $links['select'] = $goto;

        return $links;
    }

    // XXX ovo bih izbacio, cini mi se da je lakse napisati upit

    // /**
    //  * Vraca Model povezan kao has one
    //  *
    //  * one to one (vraca dete)
    //  *
    //  * @param string $model_class Klasa deteta
    //  * @param string $foreign_table_fk
    //  * @return \App\Classes\Model Instanca deteta
    //  */
    // public function hasOne($model_class, $foreign_table_fk)
    // {
    //     $m = new $model_class();
    //     $sql = "SELECT * FROM {$m->getTable()} WHERE {$foreign_table_fk} = :{$foreign_table_fk};";
    //     $pk = $this->getPrimaryKey();
    //     $params = [":{$foreign_table_fk}" => $this->$pk];
    //     $result = $this->fetch($sql, $params, $model_class);
    //     if (!$result) {
    //         return null;
    //     } else {
    //         return $result[0];
    //     }
    // }

    // /**
    //  * Vraca Modele povezane kao has many
    //  *
    //  * one to many (vraca decu)
    //  *
    //  * @param string $model_class Klasa deteta
    //  * @param string $foreign_table_fk
    //  * @return array \App\Classes\Model Niz instanci dece
    //  */
    // public function hasMany($model_class, $foreign_table_fk, $order = null)
    // {
    //     $m = new $model_class();
    //     $o = $order === null ? '' : ' ORDER BY ' . $order;
    //     $sql = "SELECT * FROM {$m->getTable()} WHERE {$foreign_table_fk} = :{$foreign_table_fk}{$o};";
    //     $pk = $this->getPrimaryKey();
    //     $params = [":{$foreign_table_fk}" => $this->$pk];
    //     $result = $this->fetch($sql, $params, $model_class);
    //     return $result;
    // }

    // /**
    //  * Vraca Model povezan kao belongs to
    //  *
    //  * one to one (vraca roditelja)
    //  * one to many (vraca roditelja)
    //  *
    //  * @param string $model_class Klasa roditelja
    //  * @param string $this_table_fk
    //  * @return \App\Classes\Model Instanca roditelja
    //  */
    // public function belongsTo($model_class, $this_table_fk)
    // {
    //     $m = new $model_class();
    //     $sql = "SELECT * FROM {$m->getTable()} WHERE {$m->getPrimaryKey()} = :{$m->getPrimaryKey()};";
    //     $params = [":{$m->getPrimaryKey()}" => $this->$this_table_fk];
    //     $result = $this->fetch($sql, $params, $model_class);
    //     if (!$result) {
    //         return null;
    //     } else {
    //         return $result[0];
    //     }
    // }

    // /**
    //  * Vraca Modele povezane kao belongs to many
    //  *
    //  * many to many (vraca drugu stranu pivot tabele)
    //  *
    //  * @param string $model_class Klasa druge strane
    //  * @param string $pivot_table Naziv pivot tabele
    //  * @param string $pt_this_table_fk FK ove strane u pivot tabeli
    //  * @param string $pt_foreign_table_fk FK druge strane u pivot tabeli
    //  * @return array \App\Classes\Model Niz instanci druge strane
    //  */
    // public function belongsToMany($model_class, $pivot_table, $pt_this_table_fk, $pt_foreign_table_fk, $order = null)
    // {
    //     $m = new $model_class();
    //     $tbl = $m->getTable();
    //     $o = $order === null ? '' : ' ORDER BY ' . $order;
    //     $pk = $this->getPrimaryKey();
    //     $params = [":{$pk}" => $this->$pk];
    //     $sql = "SELECT {$tbl}.* FROM {$tbl} JOIN {$pivot_table} ON {$tbl}.{$m->getPrimaryKey()} = {$pivot_table}.{$pt_foreign_table_fk} WHERE {$pivot_table}.{$pt_this_table_fk} = :{$pk}{$o};";
    //     $result = $this->fetch($sql, $params, $model_class);
    //     return $result;
    // }

    public function getTable()
    {
        return $this->table;
    }

    public function getPrimaryKey()
    {
        return $this->pk;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getDb()
    {
        return $this->db;
    }

    public function getLastId()
    {
        return Db::getLastInsertedId();
    }

    public function getLastCount()
    {
        return Db::getLastRowCount();
    }

    public function getLastError()
    {
        return Db::getLastError();
    }

    public function getLastQuery()
    {
        return Db::getLastQuery();
    }

    public function getTableFields()
    {
        $sql = "SHOW COLUMNS FROM {$this->table};";
        return $this->fetch($sql);
    }

    public function getTableKeys()
    {
        $sql = "SHOW KEYS FROM {$this->table};";
        return $this->fetch($sql);
    }
}
