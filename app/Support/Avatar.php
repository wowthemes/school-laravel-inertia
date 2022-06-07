<?php
namespace App\Support;


class Avatar
{
    public $url = '';

    public function __construct($email)
    {
        $default = asset("images/homestar.jpg");
        $size = 40;

        $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;

        $this->url = $grav_url;
    }
}