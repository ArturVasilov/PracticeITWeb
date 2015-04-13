<?php

class DatabaseConstants
{
    public static $DATABASE_NAME = "android_blog";

    public static $RESPONSE = "response";

    public static $ANSWER_OK = "ok";
    public static $ANSWER_FAIL = "fail";

    public static $ERROR_NO_ERRORS = 0;
    public static $ERROR_PARAMS_TOKEN = "token_error";
    public static $ERROR_SAME_LOGIN = "login_error";
    public static $ERROR_PARAMS_VOTE = "no_vote_object_param";
    public static $ERROR_LOG_IN = "no_such_email_password_pair";
    public static $ERROR_NO_SUCH_USER = "no_such_user";

    public static $ERROR_RECORD_NOT_FOUND = 404;

    public static $ERROR_ENGINE_PARAMS = 100;

    public static $ERROR_ZIP_ARCHIVE = 1001;
}