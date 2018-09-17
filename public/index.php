<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
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