<?php

namespace App\Repositories\seg_user;

use App\Models\User;

class UserRepository implements IUserRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->paginate(10);
    }
}
