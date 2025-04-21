<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Queue\ShouldQueue;

class UsersImport implements ShouldQueue
{
    /**
     * Import users from CSV file.
     *
     * @param string $filePath Path to the CSV file.
     * @return array An array containing success and error messages.
     */
    public function import(string $filePath): array
    {
        $results = [
            'success' => [],
            'errors' => [],
        ];

        if (!file_exists($filePath) || !is_readable($filePath)) {
            $results['errors'][] = 'File not found or not readable.';
            return $results;
        }

        if (($handle = fopen($filePath, 'r')) !== false) {
            $header = fgetcsv($handle); // Read header row

            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);

                try {
                    User::create([
                        'name' => $data['name'] ?? 'Unnamed',
                        'email' => $data['email'] ?? null,
                        'password' => isset($data['password'])
                            ? Hash::make($data['password'])
                            : Hash::make('password'), // Default password
                    ]);

                    $results['success'][] = "Imported user: " . ($data['email'] ?? '[unknown]');
                } catch (\Exception $e) {
                    $results['errors'][] = "Failed to import: " . ($data['email'] ?? '[unknown]') . ' - ' . $e->getMessage();
                }
            }

            fclose($handle);
        }

        return $results;
    }
}
