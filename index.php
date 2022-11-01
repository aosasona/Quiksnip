<?php
ini_set("display_errors", 0);
ini_set("display_startup_errors", 0);
ini_set("error_reporting", 0);
ini_set("log_errors", 1);
ini_set("error_log", "/var/log/php-error.log");
ini_set("ignore_repeated_errors", 1);
ini_set("ignore_repeated_source", 1);


require("vendor/autoload.php");

use Trulyao\PhpRouter\Router as Router;
use Trulyao\PhpRouter\HTTP\Response as Response;
use Trulyao\PhpRouter\HTTP\Request as Request;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$router = new Router(__DIR__ . "/src", "");

$router->get("/", function (Request $request, Response $response) {
    return $response->render("Views/index.php");
});

$router->get("/auth", function (Request $request, Response $response) {
    return $response->render("Views/auth.php");
});


$router->serve();
