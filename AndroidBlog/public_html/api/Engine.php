<?php

require_once('DatabaseConstants.php');

class Engine
{
    private $apiFunctionName;
    private $apiFunctionParams;

    static function getApiEngineByName($apiName)
    {
        require_once 'ApiBase.php';
        /** @noinspection PhpIncludeInspection */
        require_once $apiName . '.php';
        $apiClass = new $apiName();
        return $apiClass;
    }

    function __construct($apiFunctionName, $apiFunctionParams)
    {
        $this->apiFunctionParams = stripcslashes($apiFunctionParams);
        $this->apiFunctionName = explode('_', $apiFunctionName);
    }

    function createDefaultJson()
    {
        $retObject = json_decode('{}');
        $response = DatabaseConstants::$RESPONSE;
        $retObject->$response = json_decode('{}');
        return $retObject;
    }

    function callApiFunction()
    {
        $resultFunctionCall = $this->createDefaultJson();
        $apiName = $this->apiFunctionName[0];
        if (file_exists($apiName . '.php')) {
            $apiClass = Engine::getApiEngineByName($apiName);
            $apiReflection = new ReflectionClass($apiName);
            try {
                $functionName = $this->apiFunctionName[1];
                $apiReflection->getMethod($functionName);
                $response = DatabaseConstants::$RESPONSE;
                $jsonParams = json_decode($this->apiFunctionParams);
                if ($jsonParams) {
                    if (isset($jsonParams->responseBinary)) {
                        return $apiClass->$functionName($jsonParams);
                    }
                    else {
                        $resultFunctionCall->$response = $apiClass->$functionName($jsonParams);
                    }
                }
                else {
                    $resultFunctionCall->errno = DatabaseConstants::$ERROR_ENGINE_PARAMS;
                    $resultFunctionCall->error = 'Error given params';
                }
            } catch (Exception $ex) {
                $resultFunctionCall->error = $ex->getMessage();
            }
        }
        else {
            $resultFunctionCall->errno = DatabaseConstants::$ERROR_ENGINE_PARAMS;
            $resultFunctionCall->error = 'File not found';
            $resultFunctionCall->REQUEST = $_REQUEST;
        }
        return json_encode($resultFunctionCall);
    }

}