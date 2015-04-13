<?php

require_once('SessionManager.php');
$sessionManager = SessionManager::getInstance();
$sessionManager->loadSession();
if ($sessionManager->active()) {
    $name = $sessionManager->getName();
    echo "<h2 style='text-align:right; font-family: cursive; font-style:italic;
            color: #778899; padding-right: 24px'>{$name}</h2>";
}
else {
    include('main_menu.html');
}