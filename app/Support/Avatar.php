<?php
namespace App\Support;


class Avatar
{
    public $url = '';

    public function __construct($email, $model)
    {
        if ($model->attachments->count()) {
            $this->url = $model->attachments->first()->url;
        } else {
            $default = asset("images/homestar.jpg");
            $size = 40;
    
            $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    
            $this->url = $grav_url;
        }
    }
}