<?php

namespace Quiksnip\Web\Models;


class Logs extends BaseModel
{
	public int $id;
	public string $subject;
	public string $event;
	public string $data;
	public int $user_id;
	public int $snippet_id;


	public function __construct()
	{
		parent::__construct("logs");
	}

}
