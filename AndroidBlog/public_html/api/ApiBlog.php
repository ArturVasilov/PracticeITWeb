<?php

require_once('ApiBase.php');
require_once('SQLWorker.php');
require_once('DatabaseConstants.php');

class ApiBlog extends ApiBase
{
    protected $sqlWorker = null;

    /**
     * @param $methodParams mixed empty json string
     * @return mixed all articles from database in json format
     */
    public function allArticles($methodParams)
    {
        $response = $this->createDefaultJson();
        if (isset($methodParams->token) && $methodParams->token == API_PASS) {

            $this->sqlWorker = SQlWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `id`, `title`, `short_description`, `url`, `date`
                FROM `articles`";
            $this->sqlWorker->query($query);

            $data = array();
            while ($row = $this->sqlWorker->fetch_row()) {
                $data[] = $row;
            }

            $response->answer = DatabaseConstants::$ANSWER_OK;
            $response->result = $data;
        }
        else {
            $response->answer = DatabaseConstants::$ANSWER_FAIL;
            $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
        }
        return $response;
    }

    /**
     * @param $methodParams mixed empty json string
     * @return mixed all registered user in json format
     */
    public function allUsers($methodParams)
    {
        $response = $this->createDefaultJson();
        if (isset($methodParams->token) && $methodParams->token == API_PASS) {

            $this->sqlWorker = SQlWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `id`, `email`, `name` FROM `users`";
            $this->sqlWorker->query($query);

            $data = array();
            while ($row = $this->sqlWorker->fetch_row()) {
                $data[] = $row;
            }

            $response->answer = DatabaseConstants::$ANSWER_OK;
            $response->result = $data;
        }
        else {
            $response->answer = DatabaseConstants::$ANSWER_FAIL;
            $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
        }
        return $response;
    }

    /**
     * @param $methodParams mixed empty json string
     * @return mixed all comments in json format
     */
    public function allComments($methodParams)
    {
        $response = $this->createDefaultJson();
        if (isset($methodParams->token) && $methodParams->token == API_PASS) {

            $this->sqlWorker = SQlWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `id`, `article_id`, `user_id`, `text` FROM `comments`";
            $this->sqlWorker->query($query);

            $data = array();
            while ($row = $this->sqlWorker->fetch_row()) {
                $data[] = $row;
            }

            $response->answer = DatabaseConstants::$ANSWER_OK;
            $response->result = $data;
        }
        else {
            $response->answer = DatabaseConstants::$ANSWER_FAIL;
            $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
        }
        return $response;
    }

    /**
     * @param $methodParams mixed empty json string
     * @return mixed all comments in json format
     */
    public function allVotes($methodParams)
    {
        $response = $this->createDefaultJson();
        if (isset($methodParams->token) && $methodParams->token == API_PASS) {

            $this->sqlWorker = SQlWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `id`, `article_id`, `comment_id`, `user_id`, `rating` FROM `votes`";
            $this->sqlWorker->query($query);

            $data = array();
            while ($row = $this->sqlWorker->fetch_row()) {
                $data[] = $row;
            }

            $response->answer = DatabaseConstants::$ANSWER_OK;
            $response->result = $data;
        }
        else {
            $response->answer = DatabaseConstants::$ANSWER_FAIL;
            $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
        }
        return $response;
    }

    /**
     * @param $methodParams mixed json string token and article id
     * @return mixed concrete articles in json
     */
    public function getArticleById($methodParams)
    {
        $response = $this->createDefaultJson();
        if (isset($methodParams->token) && $methodParams->token == API_PASS
            && isset($methodParams->id)
        ) {
            $this->sqlWorker = SQlWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `id`, `title`, `short_description`, `url`, `date`, `content`
                FROM `articles` WHERE `id`='" . $methodParams->id . "' LIMIT 1";
            $this->sqlWorker->query($query);

            $response->answer = DatabaseConstants::$ANSWER_OK;
            while ($row = $this->sqlWorker->fetch_row()) {
                $response->article = $row;
            }

            $comments_ids = "";
            $user_ids = "";
            $comments_query = "SELECT `id`, `user_id`, `text`
                FROM `comments` WHERE `article_id`='" . $methodParams->id . "'";
            $this->sqlWorker->query($comments_query);
            $comments = array();
            while ($row = $this->sqlWorker->fetch_row()) {
                $comments_ids .= $row[0] . ",";
                $user_ids .= $row[1] . ",";
                $comments[] = $row;
            }
            $response->comments = $comments;

            $ids = substr($user_ids, 0, strlen($user_ids) - 1);
            $users_query = "SELECT `id`, `email`, `name` FROM `users` WHERE `id` IN ({$ids})";
            $this->sqlWorker->query($users_query);
            $users = array();
            while ($row = $this->sqlWorker->fetch_row()) {
                $users[] = $row;
            }
            $response->users = $users;

            $comments_ids = substr($comments_ids, 0, strlen($comments_ids) - 1);
            $votes_query = "SELECT `id`, `article_id`, `comment_id`, `user_id`, `rating`
                FROM `votes` WHERE `article_id`={$methodParams->id} OR `comment_id` IN ({$comments_ids})";
            $this->sqlWorker->query($votes_query);
            $votes = array();
            while ($row = $this->sqlWorker->fetch_row()) {
                $votes[] = $row;
            }
            $response->votes = $votes;
        }
        else {
            $response->answer = DatabaseConstants::$ANSWER_FAIL;
            $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
        }
        return $response;
    }

    /**
     * @param $methodParams mixed json string token and article id
     * @return mixed concrete articles in json
     */
    public function getArticleComments($methodParams)
    {
        $response = $this->createDefaultJson();
        if (isset($methodParams->token) && $methodParams->token == API_PASS
            && isset($methodParams->id)
        ) {

            $this->sqlWorker = SQlWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `id`
                FROM `comments` WHERE `article_id`='" . $methodParams->id . "' LIMIT 1";
            $this->sqlWorker->query($query);

            while ($row = $this->sqlWorker->fetch_row()) {
                $response->result = $row;
            }
            $response->answer = DatabaseConstants::$ANSWER_OK;
        }
        else {
            $response->answer = DatabaseConstants::$ANSWER_FAIL;
            $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
        }
        return $response;
    }

    /**
     * @param $methodParams mixed empty json string
     * @return mixed user's with such id
     */
    public function getUserById($methodParams)
    {
        $response = $this->createDefaultJson();
        if (isset($methodParams->token) && $methodParams->token == API_PASS
            && isset($methodParams->id)
        ) {

            $this->sqlWorker = SQlWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `id`, `email`, `name`
              FROM `users` WHERE `id`='" . $methodParams->id . "' LIMIT 1";
            $this->sqlWorker->query($query);

            $response->answer = DatabaseConstants::$ANSWER_OK;
            while ($row = $this->sqlWorker->fetch_row()) {
                $response->answer = $row;
            }
        }
        else {
            $response->answer = DatabaseConstants::$ANSWER_FAIL;
            $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
        }
        return $response;
    }

    /**
     * @param $methodParams mixed new persons params
     * @return mixed add new person to db and return result
     */
    public function registerPerson($methodParams)
    {
        $response = $this->createDefaultJson();

        if (isset($methodParams->token) && $methodParams->token == API_PASS) {
            $this->sqlWorker = SQLWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `email` FROM `users` WHERE `email`='" .
                $this->sqlWorker->escape_string($methodParams->email) . "' LIMIT 1";
            $this->sqlWorker->query($query);

            if ($this->sqlWorker->num_rows() === 1) {
                $response->answer = DatabaseConstants::$ANSWER_FAIL;
                $response->error = DatabaseConstants::$ERROR_SAME_LOGIN;
                return $response;
            }

            $id = 0;
            $query = "INSERT INTO `users` (`email`, `name`, `password`)
                            VALUES ('" .
                $this->sqlWorker->escape_string($methodParams->email) . "', '" .
                $this->sqlWorker->escape_string($methodParams->name) . "', '" .
                sha1($this->sqlWorker->escape_string($methodParams->password)) . "')";
            $this->sqlWorker->query($query, $id);

            $response->answer = DatabaseConstants::$ANSWER_OK;
            $response->id = $id;
        }
        else {
            $response->answer = DatabaseConstants::$ANSWER_FAIL;
            $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
        }

        return $response;
    }

    /**
     * @param $methodParams mixed check login/password and authorize
     * @return mixed result of authorizing
     */
    public function logInPerson($methodParams)
    {
        $response = $this->createDefaultJson();

        if (isset($methodParams->token) && $methodParams->token == API_PASS) {
            $this->sqlWorker = SQLWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `id`, `email`, `name` FROM `users` WHERE `email`='" .
                $this->sqlWorker->escape_string($methodParams->email) . "' AND `password`='" .
                sha1($this->sqlWorker->escape_string($methodParams->password)) . "'";
            $this->sqlWorker->query($query);

            if ($this->sqlWorker->num_rows() === 0) {
                $response->answer = DatabaseConstants::$ANSWER_FAIL;
                $response->error = DatabaseConstants::$ERROR_LOG_IN;
            }
            else {
                $response->answer = DatabaseConstants::$ANSWER_OK;
                while ($row = $this->sqlWorker->fetch_row()) {
                    $response->id = $row[0];
                    $response->name = $row[2];
                }
            }
        }
        else {
            $response->answer = DatabaseConstants::$ANSWER_FAIL;
            $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
        }

        return $response;
    }

    /**
     * @param $methodParams mixed comment json string with text and ids
     * @return mixed result of adding comment to article
     */
    public function addComment($methodParams)
    {
        $response = $this->createDefaultJson();

        if (isset($methodParams->token) && $methodParams->token == API_PASS) {
            $this->sqlWorker = SQLWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `id` FROM `users` WHERE `id`='" .
                $this->sqlWorker->escape_string($methodParams->user_id) . "'
                 AND `password`='" . sha1($this->sqlWorker->escape_string($methodParams->password)) . "' LIMIT 1";
            $this->sqlWorker->query($query);

            if ($this->sqlWorker->num_rows() !== 1) {
                $response->answer = DatabaseConstants::$ANSWER_FAIL;
                $response->error = DatabaseConstants::$ERROR_NO_SUCH_USER;
                return $response;
            }

            $id = 0;
            $insertQuery = "INSERT INTO `comments` (`article_id`, `user_id`, `text`)
                            VALUES ('" .
                $this->sqlWorker->escape_string($methodParams->article_id) . "', '" .
                $this->sqlWorker->escape_string($methodParams->user_id) . "', '" .
                $this->sqlWorker->escape_string($methodParams->text) . "');";
            $this->sqlWorker->query($insertQuery, $id);

            $response->answer = DatabaseConstants::$ANSWER_OK;
            $response->id = $id;
        }
        else {
            $response->answer = DatabaseConstants::$ANSWER_FAIL;
            $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
        }

        return $response;
    }

    /**
     * @param $methodParams mixed id for needed article
     * @return mixed all votes for article with id
     */
    public function getArticleVotes($methodParams)
    {
        $response = $this->createDefaultJson();
        if (isset($methodParams->token) && $methodParams->token == API_PASS) {

            $this->sqlWorker = SQlWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `id`, `user_id`, `rating` FROM `votes`
              WHERE `article_id`='" . $this->sqlWorker->escape_string($methodParams->article_id) . "'";
            $this->sqlWorker->query($query);

            $data = array();
            while ($row = $this->sqlWorker->fetch_row()) {
                $data[] = $row;
            }

            $response->answer = DatabaseConstants::$ANSWER_OK;
            $response->result = $data;
        }
        else {
            $response->answer = DatabaseConstants::$ANSWER_FAIL;
            $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
        }
        return $response;
    }

    /**
     * @param $methodParams mixed id for needed comment
     * @return mixed all votes for this comment
     */
    public function getCommentVotes($methodParams)
    {
        $response = $this->createDefaultJson();
        if (isset($methodParams->token) && $methodParams->token == API_PASS) {

            $this->sqlWorker = SQlWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `id`, `user_id`, `rating` FROM `votes`
              WHERE `comment_id`='" . $this->sqlWorker->escape_string($methodParams->article_id) . "'";
            $this->sqlWorker->query($query);

            $data = array();
            while ($row = $this->sqlWorker->fetch_row()) {
                $data[] = $row;
            }

            $response->answer = DatabaseConstants::$ANSWER_OK;
            $response->result = $data;
        }
        else {
            $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
        }
        return $response;
    }

    /**
     * @param $methodParams mixed rating and comment/article id for vote
     * @return mixed result of adding vote
     */
    public function vote($methodParams)
    {
        $response = $this->createDefaultJson();

        if (isset($methodParams->token) && $methodParams->token == API_PASS) {
            $this->sqlWorker = SQLWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `id` FROM `users` WHERE `id`='" .
                $this->sqlWorker->escape_string($methodParams->user_id) . "'
                 AND `password`='" . sha1($this->sqlWorker->escape_string($methodParams->password)) . "' LIMIT 1";
            $this->sqlWorker->query($query);

            if ($this->sqlWorker->num_rows() !== 1) {
                $response->answer = DatabaseConstants::$ANSWER_FAIL;
                $response->error = DatabaseConstants::$ERROR_NO_SUCH_USER;
                return $response;
            }

            $id = 0;
            if (isset($methodParams->article_id)) {
                $query = "SELECT `id` FROM `votes` WHERE `article_id`='" .
                    $this->sqlWorker->escape_string($methodParams->article_id) . "'
                    AND `user_id`='" . $this->sqlWorker->escape_string($methodParams->user_id) . "' LIMIT 1";
                $this->sqlWorker->query($query);

                if ($this->sqlWorker->num_rows() !== 1) {
                    $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
                    $remove_query = "DELETE FROM `votes` WHERE `article_id`='" .
                        $this->sqlWorker->escape_string($methodParams->article_id) . "'
                        AND `user_id`='" . $this->sqlWorker->escape_string($methodParams->user_id) . "'";
                    $this->sqlWorker->query($remove_query);
                }

                $insert_query = "INSERT INTO `votes` (`article_id`, `user_id`, `rating`)
                            VALUES ('" .
                    $this->sqlWorker->escape_string($methodParams->article_id) . "', '" .
                    $this->sqlWorker->escape_string($methodParams->user_id) . "', '" .
                    $this->sqlWorker->escape_string($methodParams->rating) . "');";
                $this->sqlWorker->query($insert_query, $id);
            }
            else if (isset($methodParams->comment_id)) {
                $query = "SELECT `id` FROM `votes` WHERE `comment_id`='" .
                    $this->sqlWorker->escape_string($methodParams->comment_id) . "'
                    AND `user_id`='" . $this->sqlWorker->escape_string($methodParams->user_id) . "' LIMIT 1";
                $this->sqlWorker->query($query);

                if ($this->sqlWorker->num_rows() !== 1) {
                    $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
                    $remove_query = "DELETE FROM `votes` WHERE `comment_id`='" .
                        $this->sqlWorker->escape_string($methodParams->comment_id) . "'
                        AND `user_id`='" . $this->sqlWorker->escape_string($methodParams->user_id) . "'";
                    $this->sqlWorker->query($remove_query);
                }

                $insert_query = "INSERT INTO `votes` (`comment_id`, `user_id`, `rating`)
                            VALUES ('" .
                    $this->sqlWorker->escape_string($methodParams->comment_id) . "', '" .
                    $this->sqlWorker->escape_string($methodParams->user_id) . "', '" .
                    $this->sqlWorker->escape_string($methodParams->rating) . "');";
                $this->sqlWorker->query($insert_query, $id);
            }
            else {
                $response->answer = DatabaseConstants::$ANSWER_FAIL;
                $response->error = DatabaseConstants::$ERROR_PARAMS_VOTE;
                return $response;
            }

            $response->answer = DatabaseConstants::$ANSWER_OK;
            $response->id = $id;
        }
        else {
            $response->answer = DatabaseConstants::$ANSWER_FAIL;
            $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
        }

        return $response;
    }
}