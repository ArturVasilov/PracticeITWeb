<?php

class ApiConstants {

    public static $ARTICLES = "articles";
    public static $ARTICLES_ID = "articles.id";
    public static $ARTICLES_TITLE = "articles.title";
    public static $ARTICLES_SHORT_DESCRIPTION = "articles.short_description";
    public static $ARTICLES_URL = "articles.url";
    public static $ARTICLES_DATE = "articles.date";

    public static $USERS = "users";
    public static $USERS_ID = "users.id";
    public static $USERS_EMAIL = "users.email";
    public static $USERS_NAME = "users.name";
    public static $USERS_PASSWORD = "users.password";
    public static $USERS_STATUS = "users.status";

    public static $COMMENTS = "comments";
    public static $COMMENTS_ID = "comments.id";
    public static $COMMENTS_ARTICLE_ID = "comments.article_id";
    public static $COMMENTS_USER_ID = "comments.user_id";
    public static $COMMENTS_TEXT = "comments.text";

    public static $VOTES = "votes";
    public static $VOTES_ID = "votes.id";
    public static $VOTES_ARTICLE_ID = "votes.article_id";
    public static $VOTES_COMMENT_ID = "votes.comment_id";
    public static $VOTES_USER_ID = "votes.user_id";
    public static $VOTES_RATING = "votes.rating";
}