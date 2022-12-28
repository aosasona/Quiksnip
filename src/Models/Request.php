<?php

namespace Quiksnip\Web\Models;


class Request extends BaseModel
{
	public int $id;
	public string $ip_address;
	public string $path;
	public string $_get;
	public string $_post;


	public function __construct()
	{
		parent::__construct();
	}

}
