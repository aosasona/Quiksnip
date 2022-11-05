<?php

namespace Quiksnip\Web\Models;


class User extends BaseModel
{
	public int $id;
	public string $name;
	public string $bio;
	public string $username;
	public string $email;
	public string $profile_image;
	public string $github_url;
	public string $auth_source;
	public string $last_login;


	public function __construct()
	{
		parent::__construct();
	}

}
