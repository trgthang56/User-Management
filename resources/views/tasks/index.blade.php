<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Task Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Add Task Button -->
                    <div class="flex justify-end gap-4 mb-4">
                        <a href="javascript:void(0)" onclick="openAddTaskModal()" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                            Add
                        </a>
                        <form id="deleteSelectedForm" method="POST" action="{{ route('user.deleteSelected') }}">
                            @csrf
                            <input type="hidden" name="selected_ids" id="selectedIds">
                            <button type="button" onclick="submitDeleteSelected()" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                Delete Selected
                            </button>
                        </form>
                    </div>

                    <!-- Search Bar -->
                    <div class="mb-4">
                        <div class="flex items-center gap-4">
                            <input type="text"
                                   id="searchInput"
                                   placeholder="Search tasks..."
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-dark">
                        </div>
                    </div>



                    <!-- Tasks Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100 dark:bg-gray-600">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <input type="checkbox" id="selectAll" class="form-checkbox">
                                        all
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Task Name
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Created By
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Assigned To
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Estimation
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Effort
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Start Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-500" id="taskTableBody">
                                @foreach($tasks as $task)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" id="{{ $task->id}}" class="form-checkbox">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $task->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $userIds = $task->created_by;
                                            $user = \App\Models\User::where('id', $userIds)->first();
                                        @endphp
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-wrap">
                                        @php
                                            $userIds = explode(',', $task->user_id);
                                            $users = \App\Models\User::whereIn('id', $userIds)->get();
                                        @endphp

                                        @foreach ($users as $user)
                                            {{ $user->name }},
                                        @endforeach

                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $task->estimation }} hours
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $task->effort }} hours
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($task->start_date)->format('H:i d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <form method="POST" action="{{ route('task.join', $task->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900">
                                                    Join
                                                </button>
                                            </form>
                                            <a href="{{ route('task.update.index', $task->id) }}"
                                               class="text-blue-600 hover:text-blue-900">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('task.destroy', $task->id) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Are you sure you want to delete this task?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Script -->
    <script>
    function searchTasks() {
        const searchInput = document.getElementById('searchInput');
        const filter = searchInput.value.toLowerCase();
        const tbody = document.getElementById('taskTableBody');
        const rows = tbody.getElementsByTagName('tr');

        for (let row of rows) {
            const nameCell = row.getElementsByTagName('td')[0]; // Task Name column
            const userCell = row.getElementsByTagName('td')[1]; // Assigned To column

            if (nameCell && userCell) {
                const nameText = nameCell.textContent || nameCell.innerText;
                const userText = userCell.textContent || userCell.innerText;

                if (nameText.toLowerCase().indexOf(filter) > -1 || userText.toLowerCase().indexOf(filter) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }
    }

    document.getElementById('searchInput').addEventListener('keyup', searchTasks);
    </script>


    <script>
        // Function to toggle all checkboxes
        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('#taskTableBody .form-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }

        // Add event listener to the "Select All" checkbox
        document.getElementById('selectAll').addEventListener('change', toggleSelectAll);

        function submitDeleteSelected() {
            const checkboxes = document.querySelectorAll('#taskTableBody .form-checkbox:checked');
            const selectedIds = Array.from(checkboxes).map(checkbox => checkbox.id);
            document.getElementById('selectedIds').value = JSON.stringify(selectedIds);

            // Submit the form
            document.getElementById('deleteSelectedForm').submit();
        }
    </script>
    <!-- Include the Add Task Modal -->
    @include('tasks.modals.add-task')

</x-app-layout>
