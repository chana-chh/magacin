<?php

namespace App\Classes;

use \PDO;
use PDOException;

/**
 * PDO MySQL wrapper
 *
 * @author ChaSha
 */
class Db
{
    private static $instance = null;
    private static $pdo;
    private static $stmt;
    private static $error;
    private array $settings;

    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone() {}
    private function __sleep() {}
    private function __wakeup() {}

    private function __construct()
    {
        try {
            $db=Cfg::get('settings')['db'];
            self::$pdo = new PDO(
                $db['dsn'],
                $db['username'],
                $db['password'],
                $db['options']
            );
        } catch (PDOException $e) {
            self::$error = $e->getMessage();
        }
    }

    public static function run(string $sql, ?array $params = null)
    {
        try {
            $stmt = self::$pdo->prepare($sql);
            $success = $stmt->execute($params);
            self::$stmt = $stmt;
        } catch (PDOException $e) {
            self::$error = $e->getMessage();
            dd($e->getMessage(), true);
        }
        return $success;
    }

    public static function fetch(string $sql, ?array $params = null, ?string $model = null, int $fetch_mode = null)
    {

        try {
            $stmt = self::run($sql, $params);
            if ($model) {
                $data = self::$stmt->fetchAll(PDO::FETCH_CLASS, $model);
            } else {
                $data = self::$stmt->fetchAll();
            }
        } catch (PDOException $e) {
            self::$error = $e->getMessage();
            dd($e->getMessage(), true);
        }
        return $data;
    }

    /**
     * Odredjuje PDO tip parametra
     *
     * @param mixed $param Parametar za upit
     * @return integer PDO tip parametra
     */
    protected static function pdoType($param)
    {
        switch (gettype($param)) {
            case 'NULL':
                return PDO::PARAM_NULL;
            case 'boolean':
                return PDO::PARAM_BOOL;
            case 'integer':
                return PDO::PARAM_INT;
            default:
                return PDO::PARAM_STR;
        }
    }

    public static function getPDO()
    {
        return self::$pdo;
    }

    public static function getPDOStatement()
    {
        return self::$stmt;
    }

    public static function getLastInsertedId()
    {
        return self::$pdo->lastInsertId();
    }

    public static function getLastRowCount()
    {
        return self::$stmt->rowCount();
    }

    public static function getLastColumnCount()
    {
        return self::$stmt->columnCount();
    }

    public static function getLastQuery()
    {
        return self::$stmt->queryString;
    }

    public static function dumpDebug()
    {
        echo '<pre><code>';
        self::$stmt->debugDumpParams();
        echo '</code></pre>';
    }

    public static function getColumnMeta(int $column_index)
    {
        return self::$stmt->getColumnMeta($column_index);
    }

    public static function getLastError()
    {
        return self::$error;
    }
}
