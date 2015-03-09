<?php

include_once("Z:/home/localhost/www/Artur/AndroidBlog/private/database/ApiBlog.php");

$email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = escape($_POST['email']);
    $password = escape($_POST['password']);

    $blog = new ApiBlog();
    $params = json_decode('{}');
    $params->token = API_PASS;
    $params->email = $email;
    $params->password = $password;

    $result = $blog->logInPerson($params);

    if ($result->result === 'error') {
        echo("Failed to log in you</br>");
        $link = "log_in_form.html";
        echo "<a href='".$link."'>Назад</a>";
    }
    else if ($result->result === DatabaseConstants::$ERROR_PARAMS_TOKEN) {
        echo("Failed to log in you</br>");
        $link = "log_in_form.html";
        echo "<a href='".$link."'>Назад</a>";
    }
    else {
        $_SESSION["email"] = $email;
        $_SESSION["id"] = $result->result;
        $_SESSION["status"] = 'user';

        $link = "index.html";
        echo "<a href='".$link."'>На главную</a>";
    }
}

function escape($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}