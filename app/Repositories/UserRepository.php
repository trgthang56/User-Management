<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUsers()
    {
        return $this->user->orderBy('role', 'asc')->paginate(20);
    }

    public function getUsersWithRolesFilter($keyword)
    {
        return $this->user->where('role', $keyword)->paginate(20);
    }

    public function search($search)
    {
        return $this->user->where('name', 'like', '%'.$search.'%')->paginate(20);
    }

    public function createUser(array $validated)
    {
        return $this->user->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);
    }
    public function updateUser($id, array $validated)
    {
        $user = $this->user->find($id);
        $user->update($validated);
        return $user;
    } public function deleteUser($id)
    {
        return $this->user->destroy($id);
    }

    public function findUser($id)
    {
        return $this->user->find($id);
    }
    public function deleteSelectedUser($ids)
    {
        return $this->user->whereIn('id', $ids)->delete();
    }


}
