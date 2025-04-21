<?php

namespace App\Services;

use App\Exports\UsersExport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
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
    public function search($search)
    {
        return $this->userRepository->search($search);
    }
    public function importUsers($request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);
        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $importer = new UsersImport();
        return $importer->import($path);
    }

    public function exportUsers(){

        $export = new UsersExport();
        $rows = $export->export();

        $fileName = 'users_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($rows) {
            $file = fopen('php://output', 'w');
            foreach ($rows as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
    public  function createUser(array $validated)
    {
        $user = $this->userRepository->createUser($validated);
        activity('create account')->log(auth()->user()->name . ' created account ' . $user->name);
        return $user;
    }
    public function updateUser($id, array $validated)
    {
        $user = $this->userRepository->updateUser($id, $validated);
        activity('update account')->log(auth()->user()->name . ' updated ' . $user->name);
        return $user;
    }
    public function deleteUser($id)
    {
        $user = $this->userRepository->findUser($id);

        if ($user->role === 'admin') {
            return 'admin';
        }

        $name = $user->name;
        $this->userRepository->deleteUser($id);
        activity('delete account')->log(auth()->user()->name . ' deleted ' . $name);

        return true;
    }

    public function deleteSelectedUser($ids)
    {
        return $this->userRepository->deleteSelectedUser($ids);
    }



}
