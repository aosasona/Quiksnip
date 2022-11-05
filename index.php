<?php

ini_set("display_errors", 0);
ini_set("display_startup_errors", 0);
ini_set("error_reporting", 0);
ini_set("log_errors", 1);
ini_set("error_log", "/var/log/php-error.log");
ini_set("ignore_repeated_errors", 1);
ini_set("ignore_repeated_source", 1);


require_once __DIR__ . "/vendor/autoload.php";

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

use Quiksnip\Web\Controllers\AuthController;
use Trulyao\PhpRouter\HTTP\Request as Request;
use Trulyao\PhpRouter\HTTP\Response as Response;
use Trulyao\PhpRouter\Router as Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

try {
	$db = new Quiksnip\Web\Database\Database();
	$db->migrate();
} catch (Exception $e) {
	print($e);
	exit;
}


$router = new Router(__DIR__ . "/src", "");

$router->get("/", function (Request $request, Response $response) {
	return $response->render("Views/index.php");
});


/**
 * Auth Routes
 */

$router->get("/auth", "\Quiksnip\Web\Middleware\AuthMiddleware::redirectIfLoggedIn",
	fn(Request $request, Response $response) => $response->render("Views/auth.php")
);

$router->post("/auth", "\Quiksnip\Web\Middleware\AuthMiddleware::redirectIfLoggedIn",
	function (Request $request, Response $response) {
		try {
			(new AuthController())->initiateGithubAuth();
		} catch (Exception $e) {
			$request->append("error", "An error occurred! Please try again.");
		}
		return $response->render("Views/auth.php", $request);
	});

$router->get("/auth/callback/github", function (Request $request, Response $response) {
	try {
		(new AuthController())->completeGithubAuth();
		return $response->redirect("/explore");
	} catch (Exception $e) {
		$request->append("error", "An error occurred! Please try again.");
		return $response->render("Views/auth.php", $request);
	}
});

$router->get("/auth/guest", "\Quiksnip\Web\Middleware\AuthMiddleware::redirectIfLoggedIn", function (Request $request, Response $response) {
	(new AuthController())->continueAsGuest();
	return $response->redirect("/explore");
});

$router->get("/auth/logout", function (Request $request, Response $response) {
	\Quiksnip\Web\Utils\Auth::logout();
	return $response->redirect("/");
});


/**
 * Explore Routes
 */

$router->get("/explore", "\Quiksnip\Web\Middleware\AuthMiddleware::protect",
	fn(Request $request, Response $response) => $response->render("Views/explore.php")
);

$router->serve();
