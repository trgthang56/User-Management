<?php

namespace App\Exports;

use App\Models\User;

class UsersExport
{
    public function export()
    {
        $users = User::all();

        $columns = ['ID', 'Name', 'Email', 'Created At'];
        $rows = [];

        // Add column headers
        $rows[] = $columns;

        // Add each user's data
        foreach ($users as $user) {
            $rows[] = [
                $user->id,
                $user->name,
                $user->email,
            ];
        }

        return $rows;
    }
}
