<?php

ini_set("display_errors", 0);
ini_set("display_startup_errors", 0);
ini_set("error_reporting", 0);
ini_set("log_errors", 1);
ini_set("error_log", "/var/log/apache2/error.log");


require_once __DIR__ . "/vendor/autoload.php";


if (session_status() == PHP_SESSION_NONE) {
	session_start();
}


use Quiksnip\Web\Controllers\AuthController;
use Quiksnip\Web\Controllers\SnippetsController;
use Quiksnip\Web\Middleware\AuthMiddleware;
use Quiksnip\Web\Middleware\SnippetMiddleware;
use Quiksnip\Web\Services\Auth;
use Quiksnip\Web\Utils\RateLimiter;
use Trulyao\PhpRouter\HTTP\Request as Request;
use Trulyao\PhpRouter\HTTP\Response as Response;
use Trulyao\PhpRouter\Router as Router;

try {

	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
	$dotenv->safeLoad();

	$db = new Quiksnip\Web\Database\Database();
	$db->migrate();

	$ip_address = $_SERVER["X_FORWARDED_FOR"] ?? $_SERVER["HTTP_X_FORWARDED_FOR"] ?? $_SERVER["HTTP_CLIENT_IP"] ?? $_SERVER["HTTP_X_REAL_IP"] ?? $_SERVER["REMOTE_ADDR"];
	RateLimiter::checkRateLimitAndThrow($ip_address, 10, (int)$_ENV["MAX_REQUESTS"] ?? 250);

	$router = new Router(__DIR__ . "/src", "");

	$router->get(
		"/",
		fn (Request $req, Response $res) => $res->render("Views/index.php")
	);

	$router->get(
		"/auth",
		fn (Request $req, Response $res) => AuthMiddleware::redirectIfLoggedIn($req, $res),
		fn (Request $req, Response $res) => $res->render("Views/auth.php")
	);

	$router->post(
		"/auth",
		fn (Request $req, Response $res) => AuthMiddleware::redirectIfLoggedIn($req, $res),
		function (Request $req, Response $res) {
			try {
				(new AuthController())->initiateGithubAuth();
			} catch (Exception $e) {
				$req->append("error", "An error occurred! Please try again.");
			}
			return $res->render("Views/auth.php", $req);
		}
	);

	$router->get("/auth/callback/github", function (Request $req, Response $res) {
		try {
			(new AuthController())->completeGithubAuth();
			return $res->redirect("/explore");
		} catch (Exception $e) {
			$req->append("error", "An error occurred! Please try again.");
			return $res->render("Views/auth.php", $req);
		}
	});

	$router->get("/auth/guest", "\Quiksnip\Web\Middleware\AuthMiddleware::redirectIfLoggedIn", function (Request $req, Response $res) {
		(new AuthController())->continueAsGuest();
		return $res->redirect("/explore");
	});

	$router->get("/auth/logout", function (Request $req, Response $res) {
		Auth::logout();
		return $res->redirect("/");
	});

	$router->get(
		"/meta/:slug",
		fn (Request $req, Response $res) => SnippetMiddleware::fetchSnippet($req, $res),
		fn (Request $req, Response $res) => $res->render("Views/meta.php", $req)
	);

	$protect = fn (Request $req, Response $res) => AuthMiddleware::protect($req, $res);

	$router->get("/profile", $protect, fn (Request $req, Response $res) => $res->render("Views/profile.php"));

	$router->get("/explore", $protect, fn (Request $req, Response $res) => $res->render("Views/explore.php"));

	$router->get("/new", $protect, fn (Request $req, Response $res) => $res->render("Views/create.php"));

	$router->post("/new", $protect, fn (Request $req, Response $res) => SnippetsController::createSnippet($req, $res));

	$router->get(
		"/s/:slug",
		fn (Request $req, Response $res) => AuthMiddleware::validateSnippetAccess($req, $res),
		fn (Request $req, Response $res) => SnippetMiddleware::fetchSnippet($req, $res),
		fn (Request $req, Response $res) => $res->render("Views/snippet.php", $req)
	);

	$router->post(
		"/s/:slug",
		fn (Request $req, Response $res) => AuthMiddleware::validateSnippetAccess($req, $res),
		fn (Request $req, Response $res) => SnippetMiddleware::fetchSnippet($req, $res),
		fn (Request $req, Response $res) => SnippetMiddleware::handlePostEvents($req, $res),
		fn (Request $req, Response $res) => $res->render("Views/snippet.php", $req)
	);


	/** Administrative */
	$router->get("/admin/stats", $protect, fn (Request $req, Response $res) => $res->render("Views/admin/index.php"));

	$router->serve();
} catch (Throwable $e) {
	if ($_ENV["ENV"] == "development") {
		var_dump($e);
		exit;
	}
	require_once __DIR__ . "/src/500.php";
	exit;
}
