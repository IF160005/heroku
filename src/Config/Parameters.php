<?php

namespace Sigita\Config;


class Parameters
{

    protected static  $connectionUrl = "mysql://host=localhost;dbname=web";
    protected static $connectionUser = "root";
    protected static $connectionPassword = "";
    protected static $login = "user";
    protected static $password = "asd";

    public static function getConnectionUrl()
    {
        return isset($_ENV["DB_HOST"]) ? $_ENV["DB_HOST"] :  self::$connectionUrl;
    }

    public static function getConnectionUser()
    {
        return isset($_ENV["DB_USER"]) ? $_ENV["DB_USER"] : self::$connectionUser;
    }

    public static function getConnectionPassword()
    {
        return isset($_ENV["DB_PASSWORD"]) ? $_ENV["DB_PASSWORD"] :  self::$connectionPassword;
    }

    public static function getLogin()
    {
        return isset($_ENV["ADMIN_LOGIN"]) ? $_ENV["ADMIN_LOGIN"] :  self::$login;
    }

    public static function getPassword()
    {
        return isset($_ENV["ADMIN_PASSWORD"]) ? $_ENV["ADMIN_PASSWORD"] :  self::$password;
    }
}