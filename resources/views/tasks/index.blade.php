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
                        <form id="deleteSelectedForm" method="POST" action="{{ route('task.deleteSelected') }}">
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" onclick="sortTable('name')">
                                        Task Name <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" onclick="sortTable('user_id')">
                                        Assigned To <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <form method="GET" action="{{ route('task.list') }}" class="flex items-center space-x-2 mb-4">
                                            <select name="keyword" class="form-select block w-1/2 mt-1 text-sm text-black bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <option value="">Status</option>
                                                <option value="1">Hoạt động</option>
                                                <option value="0">Dừng</option>
                                                <option value="2">Đang chờ</option>
                                            </select>
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                                                Apply
                                            </button>
                                        </form>
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
                                    <td  class="px-6 py-4 whitespace-normal">
                                        {{ $task->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal">
                                        @php
                                            if($task->user_id){
                                                $userIds = explode(',', $task->user_id);
                                                $users = \App\Models\User::whereIn('id', $userIds)->get();
                                            }else{
                                                $users = 'Chưa có người tham gia';
                                            }
                                        @endphp
                                        @if($users != 'Chưa có người tham gia')
                                            @foreach ($users as $user)
                                                {{ $user->name  }},
                                            @endforeach
                                        @else
                                            {{ $users }}
                                        @endif

                                    </td>
                                    <td class="px-6 py-4 whitespace-normal">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $task->status == 1 ? 'bg-green-100 text-green-800' : ($task->status == 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ $task->status == 1 ? 'hoạt động' : ($task->status == 0 ? 'dừng' : 'đang chờ') }}

                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-normal">
                                        {{ \Carbon\Carbon::parse($task->start_date)->format('H:i d/m/Y') }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2 justify-end">
                                            @if($task->status == 1)
                                                <form method="POST" action="{{ route('task.join', $task->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900">
                                                        Join
                                                    </button>
                                                </form>
                                            @endif
                                            @if(Auth::user()->role == 'admin')
                                            <a href="{{ route('task.update.index', $task->id) }}"
                                               class="text-blue-600 hover:text-blue-900">
                                                Edit
                                            </a>
                                            @else
                                                <a href="{{ route('task.detail', $task->id) }}"
                                                class="text-blue-600 hover:text-blue-900">
                                                Detail
                                                </a>
                                            @endif
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

                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $tasks->links() }}
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

        // Function to update select all checkbox state
        function updateSelectAllState() {
            const checkboxes = document.querySelectorAll('#taskTableBody .form-checkbox');
            const selectAllCheckbox = document.getElementById('selectAll');

            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            const someChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
        }

        // Add event listeners
        document.getElementById('selectAll').addEventListener('change', toggleSelectAll);

        // Add event listeners to all checkboxes
        document.querySelectorAll('#taskTableBody .form-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectAllState);
        });

        function submitDeleteSelected() {
            const checkboxes = document.querySelectorAll('#taskTableBody .form-checkbox:checked');
            const selectedIds = Array.from(checkboxes).map(checkbox => checkbox.id);
            document.getElementById('selectedIds').value = JSON.stringify(selectedIds);

            // Submit the form
            document.getElementById('deleteSelectedForm').submit();
        }
    </script>

    <script>
        // const sortOrder = {};
        let sortOrder = {
            status: 'desc'
        };
        function sortTable(column) {
            const tbody = document.getElementById('taskTableBody');
            const rows = Array.from(tbody.getElementsByTagName('tr'));
            const columnIndex = column === 'name' ? 1 : 2; // Assuming name is in the second column and email in the third

            // Determine the sort order
            const order = sortOrder[column] === 'asc' ? 1 : -1;

            // Sort rows based on the specified column and order
            rows.sort((a, b) => {
                const textA = a.getElementsByTagName('td')[columnIndex].textContent.toLowerCase();
                const textB = b.getElementsByTagName('td')[columnIndex].textContent.toLowerCase();
                return textA.localeCompare(textB) * order;
            });

            // Append sorted rows back to the table body
            rows.forEach(row => tbody.appendChild(row));

            // Toggle the sort order for the next click
            sortOrder[column] = sortOrder[column] === 'asc' ? 'desc' : 'asc';

            // Update the icon
            updateSortIcon(column);
        }

        function updateSortIcon(column) {
            // Reset all icons to the default state
            const icons = document.querySelectorAll('th i');
            icons.forEach(icon => {
                icon.classList.remove('fa-sort-up', 'fa-sort-down');
                icon.classList.add('fa-sort');
            });

            // Update the icon for the currently sorted column
            const icon = document.querySelector(`th[onclick="sortTable('${column}')"] i`);
            if (sortOrder[column] === 'asc') {
                icon.classList.remove('fa-sort');
                icon.classList.add('fa-sort-up');
            } else {
                icon.classList.remove('fa-sort');
                icon.classList.add('fa-sort-down');
            }
        }
    </script>

    <!-- Include the Add Task Modal -->
    @include('tasks.modals.add-task')

</x-app-layout>
