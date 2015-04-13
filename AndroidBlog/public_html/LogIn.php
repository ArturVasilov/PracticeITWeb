<?php

require_once('SessionManager.php');
require_once('api/ApiBlog.php');
require_once('api/DatabaseConstants.php');

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

    if ($result->answer === DatabaseConstants::$ANSWER_OK) {
        $manager = SessionManager::getInstance();
        $manager->loadSession();
        $manager->uploadUser($result->id, $email, $password, $result->name);

        $link = "index.php";
        echo "<a href='".$link."'>Homepage</a>";
    }
    elseif ($result->answer === DatabaseConstants::$ANSWER_FAIL) {
        if ($result->error === DatabaseConstants::$ERROR_LOG_IN) {
            echo("No such email or irregular password</br>");
            $link = "log_in_form.html";
            echo "<a href='" . $link . "'>Back</a>";
        }
        else {
            echo("Failed to log in you</br>");
            $link = "log_in_form.html";
            echo "<a href='" . $link . "'>Back</a>";
        }
    }
}

function escape($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}