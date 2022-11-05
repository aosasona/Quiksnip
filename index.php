<?php
ini_set("display_errors", 0);
ini_set("display_startup_errors", 0);
ini_set("error_reporting", 0);
ini_set("log_errors", 1);
ini_set("error_log", "/var/log/php-error.log");
ini_set("ignore_repeated_errors", 1);
ini_set("ignore_repeated_source", 1);


require("vendor/autoload.php");

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

use Trulyao\PhpRouter\HTTP\Request as Request;
use Trulyao\PhpRouter\HTTP\Response as Response;
use Trulyao\PhpRouter\Router as Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

try {
	$db = new Quiksnip\Quiksnip\Database\Database();
	$db->migrate();
} catch (Exception $e) {
	print($e);
	exit;
}


$router = new Router(__DIR__ . "/src", "");

$router->get("/", function (Request $request, Response $response) {
	return $response->render("Views/index.php");
});

$router->get("/auth", fn(Request $request, Response $response) => $response->render("Views/auth.php"));

$router->post("/auth", function (Request $request, Response $response) {
	try {
		(new Quiksnip\Quiksnip\Controllers\AuthController())->initiateGithubAuth();
	} catch (Exception $e) {
		$request->append("error", $e->getMessage());
	}
	return $response->render("Views/auth.php", $request);
});

$router->get("/auth/callback/github", function (Request $request, Response $response) {
	try {
		(new Quiksnip\Quiksnip\Controllers\AuthController())->completeGithubAuth();
		return $response->redirect("/explore");
	} catch (Exception $e) {
		$request->append("error", $e->getMessage());
		return $response->render("Views/auth.php", $request);
	}
});

$router->serve();
