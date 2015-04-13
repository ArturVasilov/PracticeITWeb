<?php

require_once('api/define.php');
require_once('api/ApiBlog.php');

class CommentsManager {

    public function printArticleComments($id) {
        $api = new ApiBlog();
        $params = json_decode('{}');
        $params->token = API_PASS;
        $params->id = $id;
        $response = $api->getArticleById($params);

        $comments = $response->comments;
        $size = count($comments);
        if ($size == 0) {
            return 0;
        }
        $users = $response->users;
        $votes = $response->votes;

        //TODO generate vote possibility
        foreach ($comments as $array) {
            $user_id = $array[1];
            $login = "";
            foreach ($users as $usersArray) {
                if ($usersArray[0] == $user_id) {
                    $login = $usersArray[2];
                    break;
                }
            }
            echo "<b>" . $login . "</b><br>";
            echo "<i>" . $array[2] . "</i><br>";
            echo "<hr>";
        }

        return $size;
    }

}