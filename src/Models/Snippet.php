<?php

namespace Quiksnip\Web\Models;


class Snippet extends BaseModel
{
	public int $id;
	public string $title;
	public string $lang;
	public string $content;
	public string $slug;
	public int $is_public;
	public int $allow_comments;
	public int $allow_edit;
	public int $up_votes;
	public int $down_votes;
	public int $whitelist;
	public int $owner_id;


	public function __construct()
	{
		parent::__construct();
	}

}
