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
        return $this->user->orderBy('updated_at', 'desc')->paginate(5);
    }

    public function save($data)
    {
        return $this->user->create($data);
    }

    public function update($data)
    {
        return $this->user->existe($data['id'])->update($data);
    }

    public function delete($id)
    {
        return $this->user->destroy($id);
    }

    public function getUser($id)
    {
        return $this->user->existe($id)->first();
    }
}
