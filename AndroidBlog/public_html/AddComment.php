<?php

include_once("Z:/home/localhost/www/Artur/AndroidBlog/private/database/ApiBlog.php");

$article_id = $user_id = $text = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $article_id = escape($_POST['article_id']);
    $user_id = escape($_SESSION['id']);
    $text = escape($_POST['text']);
    $email = escape($_SESSION['email']);
    $password = escape($_SESSION['password']);

    $blog = new ApiBlog();
    $params = json_decode('{}');
    $params->token = API_PASS;
    $params->article_id = $article_id;
    $params->user_id = $user_id;
    $params->text = $text;
    $params->email = $email;
    $params->password = $password;

    $result = $blog->addComment($params);

    //TODO
    if ($result->result === 'error') {
        echo("Failed to add comment</br>");
        $link = "log_in_form.html";
        echo "<a href='".$link."'>Назад</a>";
    }
    else if ($result->result === DatabaseConstants::$ERROR_PARAMS_TOKEN) {
        echo("Failed to add comment</br>");
        $link = "log_in_form.html";
        echo "<a href='".$link."'>Назад</a>";
    }
    else {
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