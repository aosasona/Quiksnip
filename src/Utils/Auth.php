<?php

namespace Quiksnip\Quiksnip\Utils;


use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GitHub;

class Auth
{
	public static function getUser()
	{
		if (self::isLoggedIn()) {
			return $_SESSION["user"];
		}

		return NULL;
	}


	public static function isLoggedIn(): bool
	{
		return isset($_SESSION["user"]);
	}


	/**
	 * @throws IdentityProviderException
	 */
	public static function gitHubLogin(): bool
	{
		$provider = new GitHub([
			'clientId' => $_ENV["GITHUB_CLIENT_ID"],
			'clientSecret' => $_ENV["GITHUB_CLIENT_SECRET"],
			'redirectUri' => $_ENV["GITHUB_REDIRECT_URI"],
		]);

		if (!isset($_GET['code'])) {
			$authUrl = $provider->getAuthorizationUrl();
			$_SESSION['oauth2state'] = $provider->getState();
			header('Location: ' . $authUrl);
			exit;
		} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
			unset($_SESSION['oauth2state']);
			header('Location: /auth');
			exit;
		} else {
			$token = $provider->getAccessToken('authorization_code', [
				'code' => $_GET['code']
			]);

			$userData = $provider->getResourceOwner($token);
			$user = new \Quiksnip\Quiksnip\Models\User();
			$email = $userData->getEmail();
			$user_id = $user->select("SELECT `id` FROM `users` WHERE `email` = :email", [":email" => $email]);

			if (count($user_id) > 0) {
				$user = $user->findOne($user_id[0]["id"]);
				$_SESSION["user"] = $user;
				return TRUE;
			} else {
				$user->username = $userData->getNickname();
				$user->email = $userData->getEmail();
				$user->profile_image = $userData->getAvatarUrl();
				$user->auth_source = "github";
				$user->save();
				$_SESSION["user"] = $user;
				return TRUE;
			}

		}

	}


	public static function logout(): void
	{
		unset($_SESSION["user"]);
	}
}