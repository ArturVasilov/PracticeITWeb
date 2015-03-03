<?php

include_once("D:/Web/Workspace/AndroidBlog/private/database/ApiBlog.php");

$name = $password = $email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = escape($_POST["name"]);
    $password = escape($_POST["password"]);
    $email = escape($_POST["email"]);

    $blog = new ApiBlog();
    $params = json_decode('{}');
    $params->email = $email;
    $params->name = $name;
    $params->password = $password;

    $result = $blog->registerPerson($params);

    echo($result->response);
    if ($result->response === "{'admin'}") {
        $_SESSION["email"] = $email;
        $_SESSION["name"] = $name;
        $_SESSION["status"] = 'admin';
    }
    else if ($result->response === "{'user'}") {
        $_SESSION["email"] = $email;
        $_SESSION["name"] = $name;
        $_SESSION["status"] = 'user';
    }
    if ($result->response === 'error') {
        echo("Failed to register you");
    }
    else {
        echo("Registration completed");
    }
}

function escape($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}