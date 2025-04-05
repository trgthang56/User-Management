<?php

namespace App\Services;

use App\Repositories\UserRepository;



class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

    }

    public function getUsers()
    {
        return $this->userRepository->getUsers();
    }
    public function getUsersWithRolesFilter($keyword)
    {
        // dd($keyword);
        return $this->userRepository->getUsersWithRolesFilter($keyword);
    }

    public function getUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function createUser(array $data)
    {
        return $this->userRepository->createUser($data);
    }

    public function updateUser($id, array $data)
    {
        return $this->userRepository->updateUser($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->deleteUser($id);
    }

    public function deleteSelectedUser($ids)
    {
        return $this->userRepository->deleteSelectedUser($ids);
    }
}