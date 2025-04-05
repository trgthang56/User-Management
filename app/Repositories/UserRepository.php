<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUsers()
    {
        return $this->user->orderBy('role', 'asc')->paginate(10);
    }

    public function getUsersWithRolesFilter($keyword)
    {
        return $this->user->where('role', $keyword)->paginate(10);
    }

    public function getUserById($id)
    {
        return $this->user->find($id);
    }

    public function createUser(array $data)
    {
        return $this->user->create($data);
    }

    public function updateUser($id, array $data)
    {
        $user = $this->user->find($id);
        if ($user) {
            $user->update($data);
            return $user;
        }
        return null;
    }

    public function deleteSelectedUser($ids){
        return $this->user->whereIn('id', $ids)->delete();
    }

    public function deleteUser($id)
    {
        return $this->user->destroy($id);
    }
}