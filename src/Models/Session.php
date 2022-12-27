<?php

namespace Quiksnip\Web\Models;


class Session extends BaseModel
{
	public int $id;
	public string $session_key;
	public mixed $data;
	public int $ttl; // in minutes
	public int $snippet_id;


	public function __construct()
	{
		parent::__construct();
	}
}
