<?php

namespace Quiksnip\Quiksnip\Models;


class UserModel extends BaseModel
{
    private string $username;
    private string $email;
    private string $profile_image;
    private string $auth_source;


    public function __construct()
    {
        parent::__construct();
    }

}
