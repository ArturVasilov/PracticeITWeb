<?php

require_once('api/ApiBlog.php');
require_once('api/DatabaseConstants.php');

$article_id = $comment_id = $user_id = $rating = $password = $article_url = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['article_id'])) {
        $article_id = escape($_POST['article_id']);
    }
    elseif (isset($_POST['comment_id'])) {
        $comment_id = escape($_POST['comment_id']);
    }
    else {
        echo("Failed to vote</br>");
        echo "<a href='".$article_url."'>Back to article</a>";
    }
    $user_id = escape($_SESSION['id']);
    $rating = escape($_POST['rating']);
    $email = escape($_SESSION['email']);
    $password = escape($_SESSION['password']);
    $article_url = escape($_POST['article_url']);

    $blog = new ApiBlog();
    $params = json_decode('{}');
    $params->token = API_PASS;
    if ($comment_id == null && $article_id != null) {
        $params->article_id = $article_id;
    }
    elseif($article_id == null && $comment_id != null) {
        $params->comment_id = $comment_id;
    }
    $params->user_id = $user_id;
    $params->rating = $rating;
    $params->password = $password;

    $result = $blog->vote($params);

    if ($result->answer === DatabaseConstants::$ANSWER_OK) {
        echo "<a href='".$article_url."'>Back to article</a>";
    }
    elseif ($result->answer === DatabaseConstants::$ANSWER_FAIL) {
        if ($result->error === DatabaseConstants::$ERROR_NO_SUCH_USER) {
            echo("You aren't authorized</br>");
            echo "<a href='".$article_url."'>Back to article</a>";
        }
        else if ($result->result === DatabaseConstants::$ERROR_PARAMS_TOKEN) {
            echo("Failed to vote</br>");
            echo "<a href='".$article_url."'>Back to article</a>";
        }
    }

}

function escape($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}