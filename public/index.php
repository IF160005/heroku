<?php
error_reporting(E_ALL);
ini_set("display_errors",1);

function errorHandler($errno, $errstr, $errfile, $errline) {

    switch ($errno) {
        case E_NOTICE:
        case E_USER_NOTICE:
        case E_DEPRECATED:
        case E_USER_DEPRECATED:
        case E_STRICT:
            echo("STRICT error $errstr at $errfile:$errline n");
            break;

        case E_WARNING:
        case E_USER_WARNING:
            echo("WARNING error $errstr at $errfile:$errline n");
            break;

        case E_ERROR:
        case E_USER_ERROR:
        case E_RECOVERABLE_ERROR:
            exit("FATAL error $errstr at $errfile:$errline n");

        default:
            exit("Unknown error at $errfile:$errline n");
    }
}

set_error_handler("errorHandler");
require __DIR__ . "/../vendor/autoload.php";

session_start();

use Sigita\Controller\IndexController;
use Sigita\Controller\OrdersController;

if (isset($_GET["controller"])) {
    $controllerClass = $_GET["controller"];
} else {
    $controllerClass = "Index";
}
$contr = "Sigita\Controller\\{$controllerClass}Controller";
if (class_exists($contr)) {
    $controller = new $contr();
    if (isset($_GET["action"])) {
        $functionClass = $_GET["action"];
    } else {
        $functionClass = "Index";
    }
    $funcName = "{$functionClass}Action";

    if (method_exists($contr, $funcName)) {
        $controller->$funcName();
    }

}