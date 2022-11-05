<?php

namespace Quiksnip\Quiksnip\Controllers;

use Exception;
use JetBrains\PhpStorm\NoReturn;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\Github;
use Quiksnip\Quiksnip\Models\User;

class AuthController
{
	private Github $github_provider;


	public function __construct()
	{
		$this->github_provider = new GitHub([
			'clientId' => $_ENV["GITHUB_CLIENT_ID"],
			'clientSecret' => $_ENV["GITHUB_CLIENT_SECRET"],
			'redirectUri' => $_ENV["GITHUB_REDIRECT_URI"],
		]);
	}


	#[NoReturn] public function initiateGithubAuth(): void
	{
		// TODO: require repo access to ve able to import code snippets from github
		$options = [
			"state" => "OPTIONAL_CUSTOM_CONFIGURED_STATE",
			"scope" => ["user"],
		];
		$authUrl = $this->github_provider->getAuthorizationUrl($options);
		$_SESSION['oauth2state'] = $this->github_provider->getState();
		header('Location: ' . $authUrl);
		exit;
	}


	/**
	 * @throws IdentityProviderException
	 */
	public function completeGithubAuth(): bool
	{
		if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
			unset($_SESSION['oauth2state']);
			header('Location: /auth');
			exit;
		}

		$token = $this->github_provider->getAccessToken('authorization_code', [
			'code' => $_GET['code']
		]);

//		$userData = $this->github_provider->getResourceOwner($token);

		try {

			// We got an access token, let's now get the user's details
			$userData = $this->github_provider->getResourceOwner($token);
			var_dump(json_encode($userData->toArray()));
			exit;
		} catch (Exception $e) {
			exit('Oh dear...');
		}

		$user = new User();
		$email = $userData->getEmail();
		$user_id = $user->select("SELECT `id` FROM `users` WHERE `email` = :email", [":email" => $email]);

		if (count($user_id) > 0) {
			$user = $user->findOne($user_id[0]["id"]);
			$_SESSION["user"] = $user;
			return true;
		} else {
			$user->username = $userData->getNickname();
			$user->email = $userData->getEmail();
			$user->profile_image = $userData->getAvatarUrl();
			$user->auth_source = "github";
			$user->save();
			$_SESSION["user"] = $user;
			return true;
		}
	}

}
