<?php

header('Content-type: text/html; charset=UTF-8');
error_reporting(E_ERROR);

if (count($_REQUEST) > 0) {
    require_once 'Engine.php';
    foreach ($_REQUEST as $apiFunctionName => $apiFunctionParams) {
        $Engine = new Engine($apiFunctionName, $apiFunctionParams);
        echo $Engine->callApiFunction();
        break;
    }
}
else {
    /** @noinspection PhpUndefinedClassInspection */
    /** @var JSONObject $jsonError */
    $jsonError->error = 'No function called';
    echo json_encode($jsonError);
}