<?php

require_once('ApiBase.php');
require_once('SQLWorker.php');
require_once('DatabaseConstants.php');

class ApiBlog extends ApiBase
{
    protected $sqlWorker = null;

    //TODO : work with functions

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
            while($row = $this->sqlWorker->fetch_row()){
                $data[] = $row;
            }

            $response->answer = $data;
        }
        else {
            $response->errorno = DatabaseConstants::$ERROR_PARAMS_TOKEN;
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
            && isset($methodParams->id)) {

            $this->sqlWorker = SQlWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `id`, `title`, `short_description`, `url`, `date`
                FROM `articles` WHERE `id`='" . $methodParams->id . "' LIMIT 1";
            $this->sqlWorker->query($query);

            while($row = $this->sqlWorker->fetch_row()){
                $response->result = $row;
            }
        }
        else {
            $response->errorno = DatabaseConstants::$ERROR_PARAMS_TOKEN;
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
            while($row = $this->sqlWorker->fetch_row()){
                $data[] = $row;
            }

            $response->answer = $data;
        }
        else {
            $response->errorno = DatabaseConstants::$ERROR_PARAMS_TOKEN;
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
            && isset($methodParams->id)) {

            $this->sqlWorker = SQlWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `id`, `email`, `name`
              FROM `users` WHERE `id`='" . $methodParams->id . "' LIMIT 1";
            $this->sqlWorker->query($query);

            while($row = $this->sqlWorker->fetch_row()){
                $response->result = $row;
            }
        }
        else {
            $response->errorno = DatabaseConstants::$ERROR_PARAMS_TOKEN;
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
                $response->error = DatabaseConstants::$ERROR_SAME_LOGIN;
                return $response;
            }

            $id = 0;
            $query = "INSERT INTO `users` (`email`, `name`, `password`, `status`)
                            VALUES ('" .
                $this->sqlWorker->escape_string($methodParams->email) . "', '" .
                $this->sqlWorker->escape_string($methodParams->name) . "', '" .
                sha1($this->sqlWorker->escape_string($methodParams->password)) . "', 'user'" . ");";
            $this->sqlWorker->query($query, $id);

            $response->id = $id;
        }
        else {
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

            $query = "SELECT `id` FROM `users` WHERE `email`='" .
                $this->sqlWorker->escape_string($methodParams->email) . "' AND `password`='" .
                sha1($this->sqlWorker->escape_string($methodParams->password)) . "'";
            $this->sqlWorker->query($query);

            if ($this->sqlWorker->num_rows() === 0) {
                $response->result = "error";
            }
            else {
                while ($row = $this->sqlWorker->fetch_row()) {
                    $response->result = $row[0];
                }
            }
        }
        else {
            $response->result = DatabaseConstants::$ERROR_PARAMS_TOKEN;
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

            $query = "SELECT `id` FROM `users` WHERE `email`='" .
                $this->sqlWorker->escape_string($methodParams->email) . "'
                 AND `password`='" . sha1($this->sqlWorker->escape_string($methodParams->password)) . "' LIMIT 1";
            $this->sqlWorker->query($query);

            if ($this->sqlWorker->num_rows() !== 1) {
                $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
                return $response;
            }

            $id = 0;
            $query = "INSERT INTO `comments` (`article_id`, `user_id`, `text`)
                            VALUES ('" .
                $this->sqlWorker->escape_string($methodParams->article_id) . "', '" .
                $this->sqlWorker->escape_string($methodParams->user_id) . "', '" .
                $this->sqlWorker->escape_string($methodParams->text) . "');";
            $this->sqlWorker->query($query, $id);

            $response->id = $id;
        }
        else {
            $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
        }

        return $response;
    }

    /**
     * @param $methodParams mixed id for needed article
     * @return mixed all votes for article with id
     */
    public function getArticlesVotes($methodParams)
    {
        $response = $this->createDefaultJson();
        if (isset($methodParams->token) && $methodParams->token == API_PASS) {

            $this->sqlWorker = SQlWorker::getInstance();
            $this->sqlWorker->loadEngine();

            $query = "SELECT `id`, `user_id`, `rating` FROM `votes`
              WHERE `article_id`='" . $this->sqlWorker->escape_string($methodParams->article_id) . "'";
            $this->sqlWorker->query($query);

            $data = array();
            while($row = $this->sqlWorker->fetch_row()){
                $data[] = $row;
            }

            $response->answer = $data;
        }
        else {
            $response->errorno = DatabaseConstants::$ERROR_PARAMS_TOKEN;
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
            while($row = $this->sqlWorker->fetch_row()){
                $data[] = $row;
            }

            $response->answer = $data;
        }
        else {
            $response->errorno = DatabaseConstants::$ERROR_PARAMS_TOKEN;
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

            $query = "SELECT `id` FROM `users` WHERE `email`='" .
                $this->sqlWorker->escape_string($methodParams->email) . "'
                 AND `password`='" . sha1($this->sqlWorker->escape_string($methodParams->password)) . "' LIMIT 1";
            $this->sqlWorker->query($query);

            if ($this->sqlWorker->num_rows() !== 1) {
                $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
                return $response;
            }

            $id = 0;
            $query = "";
            if (isset($methodParams->article_id)) {
                $query = "INSERT INTO `votes` (`article_id`, `user_id`, `rating`)
                            VALUES ('" .
                    $this->sqlWorker->escape_string($methodParams->article_id) . "', '" .
                    $this->sqlWorker->escape_string($methodParams->user_id) . "', '" .
                    $this->sqlWorker->escape_string($methodParams->rating) . "');";
            }
            else if(isset($methodParams->comment_id)) {
                $query = "INSERT INTO `votes` (`comment_id`, `user_id`, `rating`)
                            VALUES ('" .
                    $this->sqlWorker->escape_string($methodParams->comment_id) . "', '" .
                    $this->sqlWorker->escape_string($methodParams->user_id) . "', '" .
                    $this->sqlWorker->escape_string($methodParams->rating) . "');";
            }
            else {
                $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
            }
            $this->sqlWorker->query($query, $id);

            $response->id = $id;
        }
        else {
            $response->error = DatabaseConstants::$ERROR_PARAMS_TOKEN;
        }

        return $response;
    }
}