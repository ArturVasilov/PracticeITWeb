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

        $article = $response->article;
        $comments = $response->comments;
        $size = count($comments);
        if ($size == 0) {
            return 0;
        }
        $users = $response->users;
        $votes = $response->votes;

        $votesCount = 0;
        $sum = 0;
        foreach ($votes as $array) {
            $article_id = $array[1];
            if ($article_id != 0) {
                $sum += $array[4];
                $votesCount++;
            }
        }
        if ($votesCount == 0) {
            echo "<b>There are no votes for this article yet</b>";
        }
        else {
            echo "<b>Article rating - " . $sum * 1.0 / $votesCount . "</b>";
        }
        echo "<br>";

        $sessionManager = SessionManager::getInstance();
        if ($sessionManager->active()) {
            echo $this->voteFormForArticle($article[0], $article[3]);
        }
        else {
            $logIn = "log_in_form.html";
            echo "<a href='" . $logIn . "'>Log in to add vote</a>";
        }
        echo "<hr>";

        foreach ($comments as $array) {
            $comment_id = $array[0];
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

            $votesCount = 0;
            $sum = 0;
            foreach ($votes as $votesArray) {
                $comment = $votesArray[2];
                if ($comment == $comment_id) {
                    $sum += $votesArray[4];
                    $votesCount++;
                }
            }
            if ($votesCount == 0) {
                echo "<b>There are no votes for this comment yet</b>";
            }
            else {
                echo "<b>Comment rating - " . $sum * 1.0 / $votesCount . "</b>";
            }
            echo "<br>";

            if ($sessionManager->active()) {
                echo $this->voteFormForComment($comment_id, $article[3]);
            }
            else {
                $logIn = "log_in_form.html";
                echo "<a href='" . $logIn . "'>Log in to add vote</a>";
            }

            echo "<hr>";
        }

        return $size;
    }

    public function voteFormForArticle($article_id, $article_url) {
        return "
            <form action='Vote.php' method='post'>
                <select name='rating'>
                    <option value='1'>1</option>
                    <option value='2'>2</option>
                    <option value='3'>3</option>
                    <option value='4'>4</option>
                    <option value='5' selected='selected'>5</option>
                </select>
                <input type='hidden' name='article_id' value='{$article_id}'>
                <input type='hidden' name='article_url' value='{$article_url}'>
                <button type='submit'>Post</button>
            </form>
        ";
    }

    public function voteFormForComment($comment_id, $article_url) {
        return "
            <form action='Vote.php' method='post'>
                <select name='rating'>
                    <option value='1'>1</option>
                    <option value='2'>2</option>
                    <option value='3'>3</option>
                    <option value='4'>4</option>
                    <option value='5' selected='selected'>5</option>
                </select>
                <input type='hidden' name='comment_id' value='{$comment_id}'>
                <input type='hidden' name='article_url' value='{$article_url}'>
                <button type='submit'>Post</button>
            </form>
        ";
    }

}