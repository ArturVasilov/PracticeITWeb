<?php

require_once('SQLWorker.php');

class ApiBase
{
    protected $sqlWorker = null;

    function __construct()
    {
    }

    function __destruct()
    {
    }

    function createDefaultJson()
    {
        $retObject = json_decode('{}');
        return $retObject;
    }

    function fillJSON(&$jsonObject, &$stmt, &$mySQLWorker)
    {
        $row = array();
        $mySQLWorker->stmt_bind_assoc($stmt, $row);
        while ($stmt->fetch()) {
            foreach ($row as $key => $value) {
                $key = strtolower($key);
                $jsonObject->$key = $value;
            }
            break;
        }
        return $jsonObject;
    }
}