<?php

namespace Quiksnip\Quiksnip\Models;


class User extends BaseModel
{
	public int $id;
	public string $username;
	public string $email;
	public string $profile_image;
	public string $auth_source;


	public function __construct()
	{
		parent::__construct();
	}

}
