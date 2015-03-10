<?php

include_once("Z:/home/localhost/www/Artur/AndroidBlog/private/database/ApiBlog.php");

$article_id = $comment_id = $user_id = $rating = $email = $password = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['article_id'])) {
        $article_id = escape($_POST['article_id']);
    }
    else if (isset($_POST['comment_id'])) {
        $comment_id = escape($_POST['comment_id']);
    }
    $user_id = escape($_SESSION['id']);
    $rating = escape($_POST['rating']);
    $email = escape($_SESSION['email']);
    $password = escape($_SESSION['password']);

    $blog = new ApiBlog();
    $params = json_decode('{}');
    $params->token = API_PASS;
    $params->article_id = $article_id;
    $params->comment_id = $comment_id;
    $params->user_id = $user_id;
    $params->rating = $rating;
    $params->email = $email;
    $params->password = $password;

    $result = $blog->addComment($params);

    //TODO
    if ($result->result === 'error') {
        echo("Failed to vote</br>");
        $link = "log_in_form.html";
        echo "<a href='".$link."'>Назад</a>";
    }
    else if ($result->result === DatabaseConstants::$ERROR_PARAMS_TOKEN) {
        echo("Failed to vote</br>");
        $link = "log_in_form.html";
        echo "<a href='".$link."'>Назад</a>";
    }
    else {
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $result->result;
        $_SESSION['status'] = 'user';

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