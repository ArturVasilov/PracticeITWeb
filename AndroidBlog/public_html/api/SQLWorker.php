<?php

include_once('define.php');
require_once('Engine.php');

class SQlWorker
{
    private $engine = null;
    private $transaction = false;

    private static $instance = false;

    public $result;

    public static function getInstance()
    {
        if (self::$instance === false) {
            self::$instance = new SQLWorker;
        }
        return self::$instance;
    }

    private function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function loadEngine()
    {
        if ($this->engine != null) return false;

        error_reporting(0);

        if (!$this->engine = new mysqli (DB_HOST, DB_USER, DB_PASS, DB_NAME)) {
            throw new Exception ('Server Connection Failed');
        }

        error_reporting(E_ALL);

        $this->engine->query("/*!40101 SET NAMES 'utf8' */");

        return $this;
    }

    public function query($sQuery, &$insertId = 0)
    {
        if (!$this->result = $this->engine->query($sQuery, $insertId)) {
            if ($this->transaction) {
                $this->engine->query("ROLLBACK");
                $this->transaction = false;
            }
        }

        $insertId = $this->engine->insert_id;
        return $this->result;
    }

    public function fetch_row()
    {
        return $this->result->fetch_row();
    }

    public function fetch_array()
    {
        return $this->result->fetch_assoc();
    }

    public function num_rows()
    {
        return $this->result->num_rows;
    }

    public function reset_pointer($position = 0)
    {
        return $this->result->data_seek($position);
    }

    public function startTransaction()
    {
        $this->engine->query("SET AUTOCOMMIT=0");
        $this->engine->query("START TRANSACTION");
        $this->transaction = true;
    }

    public function stopTransaction()
    {
        if ($this->engine->transaction) {
            $this->engine->query("COMMIT");
            $this->transaction = false;
        }
    }

    public static function getCountQueries()
    {
        return self::$countQueries;
    }

    public function escape_string($string)
    {
        return $this->engine->escape_string($string);
    }

}