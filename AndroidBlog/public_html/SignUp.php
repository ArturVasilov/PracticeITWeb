<?php

require_once('SessionManager.php');
require_once('api/ApiBlog.php');
require_once('api/DatabaseConstants.php');

$name = $password = $email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = escape($_POST['name']);
    $password = escape($_POST['password']);
    $email = escape($_POST['email']);

    $blog = new ApiBlog();
    $params = json_decode('{}');
    $params->token = API_PASS;
    $params->email = $email;
    $params->password = $password;
    $params->name = $name;

    $result = $blog->registerPerson($params);

    if ($result->answer === DatabaseConstants::$ANSWER_OK) {
        $manager = SessionManager::getInstance();
        $manager->loadSession();
        $manager->uploadUser($result->id, $email, $password, $name);

        $link = "index.php";
        echo "<a href='".$link."'>Homepage</a>";
    }
    elseif (isset($result->error)) {
        if ($result->error === DatabaseConstants::$ERROR_SAME_LOGIN) {
            echo("Such email is already exist</br>");
            $link = "registration_form.html";
            echo "<a href='".$link."'>Back</a>";
        }
        else if ($result->error === DatabaseConstants::$ERROR_PARAMS_TOKEN) {
            echo("Failed to register you</br>");
            $link = "registration_form.html";
            echo "<a href='".$link."'>Back</a>";
        }
    }
}

function escape($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}