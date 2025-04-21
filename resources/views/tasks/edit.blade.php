<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="updateTaskForm" method="POST" action="{{ route('task.update', $task->id) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="flex gap-4">
                            <div class="w-full">
                                <x-input-label for="name" :value="__('Task Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $task->name)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="flex items-center gap-4">
                                <input type="text"
                                       id="searchUserInput"
                                       placeholder="Search users..."
                                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-dark">
                            </div>
                        </div>
                        <div class="overflow-x-auto hidden" id="userTableContainer">
                            <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg overflow-hidden">
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-500" id="taskTableBody">
                                    @foreach($users2 as $user2)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-600" data-user-id="{{ $user2->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $user2->name }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $userIds = explode(',', $task->user_id);
                                    $assignedUsers = \App\Models\User::whereIn('id', $userIds)->get();
                                @endphp
                                @foreach($assignedUsers as $user)
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-900 dark:text-gray-100">{{ $user->name }}</span>
                                        <button onclick="removeUser('{{ $user->id }}')" class="text-red-600 hover:text-red-900">
                                            x
                                        </button>
                                        <input type="hidden" name="user_ids[]" value="{{ $user->id }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description"
                                      name="description"
                                      class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                      rows="4">{{ old('description', $task->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="flex gap-4">
                            <div class="w-1/3">
                                <x-input-label for="estimation" :value="__('Estimation (hours)')" />
                                <x-text-input id="estimation" name="estimation" type="number" class="mt-1 block w-full" min="0" :value="old('estimation', $task->estimation)" />
                                <x-input-error class="mt-2" :messages="$errors->get('estimation')" />
                            </div>

                            <div class="w-1/3">
                                <x-input-label for="effort" :value="__('Effort (hours)')" />
                                <x-text-input id="effort" name="effort" type="number" class="mt-1 block w-full" min="0" :value="old('effort', $task->effort)" />
                                <x-input-error class="mt-2" :messages="$errors->get('effort')" />
                            </div>
                            <div class="w-1/3">
                                <x-input-label for="start_date" :value="__('Start Date')" />
                                <x-text-input id="start_date" name="start_date" type="datetime-local" class="mt-1 block w-full" :value="old('start_date', $task->start_date->format('Y-m-d\TH:i'))" />
                                <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                            </div>
                        </div>


                    </form>
                    <div class="mt-4 flex items-center justify-between gap-2">
                        <x-primary-button class="px-4 py-2" type="submit" form="updateTaskForm">{{ __('Update Task') }}</x-primary-button>
                        <form method="POST" action="{{ route('task.join', $task->id) }}" class="inline">
                            @csrf
                            <x-primary-button class="px-4 py-2" type="submit">
                                Join
                            </x-primary-button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
    function removeUser(userId) {
        // Remove the user from the DOM
        const userElement = document.querySelector(`button[onclick="removeUser('${userId}')"]`).parentElement;
        userElement.remove();

        // Send an AJAX request to update the server
        fetch(`/task-remove/${userId}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('User removed successfully');
            } else {
                console.error('Failed to remove user');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    document.getElementById('searchUserInput').addEventListener('keyup', function() {
        const query = this.value.toLowerCase();
        const tableContainer = document.getElementById('userTableContainer');
        const rows = document.querySelectorAll('#taskTableBody tr');
        let hasMatch = false;

        rows.forEach(row => {
            const userName = row.textContent.toLowerCase();
            if (userName.includes(query)) {
                row.style.display = '';
                hasMatch = true;
            } else {
                row.style.display = 'none';
            }
        });

        if (query === '' || query === null) {
            // If the search input is empty, hide the table
            tableContainer.classList.add('hidden');
        } else if (hasMatch) {
            tableContainer.classList.remove('hidden');
        } else {
            tableContainer.classList.add('hidden');
        }
    });

    function addUserToAssigned(userId, userName) {
        const assignedContainer = document.querySelector('.flex.flex-wrap.gap-2');

        // Check if the user is already assigned
        if (document.querySelector(`input[value="${userId}"]`)) {
            alert('User is already assigned.');
            return;
        }

        // Create a new div for the assigned user
        const userDiv = document.createElement('div');
        userDiv.className = 'flex items-center gap-2';
        userDiv.innerHTML = `
            <span class="text-gray-900 dark:text-gray-100">${userName}</span>
            <button onclick="removeUser('${userId}')" class="text-red-600 hover:text-red-900">x</button>
            <input type="hidden" name="user_ids[]" value="${userId}">
        `;

        // Append the new user div to the assigned users container
        assignedContainer.appendChild(userDiv);
    }

    // Add click event listeners to each user row
    document.querySelectorAll('#taskTableBody tr').forEach(row => {
        row.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const userName = this.textContent.trim();
            addUserToAssigned(userId, userName);
        });
    });
    </script>
</x-app-layout>
