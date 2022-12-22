<?php

namespace Quiksnip\Web\Controllers;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\Github as GitHub;
use Quiksnip\Web\Utils\UUID;

class AuthController
{
	private GitHub $github_provider;


	public function __construct()
	{
		$this->github_provider = new GitHub([
			'clientId' => $_ENV["GITHUB_CLIENT_ID"],
			'clientSecret' => $_ENV["GITHUB_CLIENT_SECRET"],
			'redirectUri' => $_ENV["GITHUB_REDIRECT_URI"],
		]);
	}


	public function initiateGithubAuth(): void
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
	public function completeGithubAuth(): void
	{
		if (empty($_GET['state']) || ($_GET['state'] !== ($_SESSION['oauth2state'] ?? null))) {
			unset($_SESSION['oauth2state']);
			header('Location: /auth');
			exit;
		}

		$token = $this->github_provider->getAccessToken('authorization_code', [
			'code' => $_GET['code']
		]);


		$userData = $this->github_provider->getResourceOwner($token)->toArray();

		$user = new \Quiksnip\Web\Models\User();
		$email = $userData["email"];
		$db_user = $user->selectOne("SELECT `id` FROM `users` WHERE `email` = :email", [":email" => $email]);

		$last_login = date("Y-m-d H:i:s");

		if (!!$db_user) {
			$user->query("UPDATE `users` SET `last_login` = :last_login WHERE `email` = :email", [":last_login" => $last_login, ":email" => $email]);
			$user = $user->findOne($db_user["id"]);
		} else {
			$user->name = $userData["name"] ?? "";
			$user->bio = $userData["bio"] ?? "";
			$user->username = $userData["login"];
			$user->email = $email;
			$user->profile_image = $userData["avatar_url"];
			$user->github_url = $userData["html_url"];
			$user->auth_source = "github";
			$user->last_login = $last_login;
			$user->save();
		}
		$_SESSION["auth_token"] = $token->getToken();
		$_SESSION["user"] = $user;
	}


	public function continueAsGuest(): void
	{
		$_SESSION["auth_token"] = UUID::generate();
		$_SESSION["user"] = [
			"id" => 0,
			"name" => "Guest",
			"bio" => "",
			"username" => "guest",
			"email" => "",
			"profile_image" => "",
			"github_url" => "",
		];
		$_SESSION["is_guest"] = true;
	}
}
