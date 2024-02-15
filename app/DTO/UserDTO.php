<?php

namespace App\DTO;

use App\Models\User;

class UserDTO
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function userEmail()
    {
        return $this->user->email;
    }

    public function userName()
    {
        return $this->user->name;
    }

}
