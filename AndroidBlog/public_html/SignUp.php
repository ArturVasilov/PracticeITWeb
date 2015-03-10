<?php

include_once("Z:/home/localhost/www/Artur/AndroidBlog/private/database/ApiBlog.php");

$name = $password = $email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = escape($_POST['name']);
    $password = escape($_POST['password']);
    $email = escape($_POST['email']);

    $blog = new ApiBlog();
    $params = json_decode('{}');
    $params->token = API_PASS;
    $params->email = $email;
    $params->name = $name;
    $params->password = $password;

    $result = $blog->registerPerson($params);

    if (isset($result->error)) {
        if ($result->error === DatabaseConstants::$ERROR_SAME_LOGIN) {
            echo("Such email is already exist</br>");
            $link = "registration_form.html";
            echo "<a href='".$link."'>Назад</a>";
        }
        else if ($result->error === DatabaseConstants::$ERROR_PARAMS_TOKEN) {
            echo("Failed to register you</br>");
            $link = "registration_form.html";
            echo "<a href='".$link."'>Назад</a>";
        }
    }
    else {
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        $_SESSION['id'] = $result->id;
        $_SESSION['status'] = 'user';
        $_SESSION['password'] = $password;

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