<?php

class SessionManager
{
    private static $INSTANCE = null;

    public static function getInstance()
    {
        if (self::$INSTANCE == null) {
            self::$INSTANCE = new SessionManager();
        }
        return self::$INSTANCE;
    }

    public function loadSession()
    {
        session_start();
    }

    public function destroy()
    {
        if (!empty($_SESSION['id'])) {
            unset($_SESSION['id']);
        }
        if (!empty($_SESSION['email'])) {
            unset($_SESSION['email']);
        }
        if (!empty($_SESSION['password'])) {
            unset($_SESSION['password']);
        }
        if (!empty($_SESSION['name'])) {
            unset($_SESSION['name']);
        }
        session_destroy();
    }

    public function active()
    {
        return !empty($_SESSION['id']);
    }

    public function uploadUser($id, $email, $password, $name)
    {
        $_SESSION['id'] = $id;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['name'] = $name;
    }

    public function getId()
    {
        return $_SESSION['id'];
    }

    public function getEmail()
    {
        return $_SESSION['email'];
    }

    public function getPassword()
    {
        return $_SESSION['password'];
    }

    public function getName()
    {
        return $_SESSION['name'];
    }
}