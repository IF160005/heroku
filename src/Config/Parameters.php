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

        return getenv("DB_HOST") ?  getenv("DB_HOST") :  self::$connectionUrl;
    }

    public static function getConnectionUser()
    {
        return getenv("DB_USER") ?  getenv("DB_USER") : self::$connectionUser;
    }

    public static function getConnectionPassword()
    {
        return  getenv("DB_PASSWORD") ? getenv("DB_PASSWORD") :  self::$connectionPassword;
    }

    public static function getLogin()
    {
        return  getenv("ADMIN_LOGIN") ? getenv("ADMIN_LOGIN") :  self::$login;
    }

    public static function getPassword()
    {
        return getenv("ADMIN_PASSWORD") ? getenv("ADMIN_PASSWORD") :  self::$password;
    }
}