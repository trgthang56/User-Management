<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-end gap-4 mb-4">
                        <a href="javascript:void(0)" onclick="openAddUserModal()" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                            Add
                        </a>
                        <a href="javascript:void(0)" onclick="openImportModal()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Import
                        </a>
                        <a href="{{ route('user.export') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Export to Excel
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
                        <form method="GET" action="{{ route('user.list') }}" class="flex items-center gap-4">
                            <input type="text"
                                   id="searchInput"
                                   name="search"
                                   placeholder="Search users..."
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-dark">
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Search
                            </button>
                        </form>
                    </div>



                    <!-- Users Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100 dark:bg-gray-600">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <input type="checkbox" id="selectAll" class="form-checkbox">
                                        all
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" onclick="sortTable('name')">
                                        Name <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" onclick="sortTable('email')">
                                        Email <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" onclick="sortTable('birthday')">
                                        Birthday <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-black-500 dark:text-gray-300 uppercase tracking-wider">
                                        <!-- Filter Form -->
                                        <form method="GET" action="{{ route('user.list') }}" class="flex items-center space-x-2 mb-4">
                                            <select name="keyword" class="form-select block w-1/2 mt-1 text-sm text-black bg-gray-200 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <option value="">Role</option>
                                                <option value="admin">Admin</option>
                                                <option value="manager">Manager</option>
                                                <option value="user">User</option>
                                                <!-- Add more roles as needed -->
                                            </select>
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                                                Apply
                                            </button>
                                        </form>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-500" id="userTableBody">
                                @foreach($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" id="{{ $user->id}}" class="form-checkbox">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ $user->id}}" style="cursor: default;" onclick="event.preventDefault()">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($user->birthday)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span id="{{ $user->role }}" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $user->role === 'admin' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    @if(Auth::user()->role == 'admin')
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center gap-2">
                                            <button onclick="openEditModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}', '{{ $user->birthday }}')"
                                                    class="text-blue-200 hover:text-blue-500">
                                                Edit
                                            </button>
                                            {{-- <button onclick="openEditModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')"
                                                class="text-blue-600 hover:text-blue-900">
                                                Export
                                            </button> --}}
                                            <form method="POST" action="{{ route('user.destroy', $user->id) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this script at the bottom of the file -->
    <script>
        let sortOrder = {
            name: 'asc',
            email: 'asc',
            birthday: 'asc'
        };

        function sortTable(column) {
            const tbody = document.getElementById('userTableBody');
            const rows = Array.from(tbody.getElementsByTagName('tr'));
            let columnIndex;

            if (column === 'name') {
                columnIndex = 1;
            } else if (column === 'email') {
                columnIndex = 2;
            } else if (column === 'birthday') {
                columnIndex = 3;
            }

            // Determine the sort order
            const order = sortOrder[column] === 'asc' ? 1 : -1;

            // Sort rows based on the specified column and order
            rows.sort((a, b) => {
                let textA, textB;

                if (column === 'birthday') {
                    textA = new Date(a.getElementsByTagName('td')[columnIndex].textContent.split('-').reverse().join('-'));
                    textB = new Date(b.getElementsByTagName('td')[columnIndex].textContent.split('-').reverse().join('-'));
                    return (textA - textB) * order;
                } else {
                    textA = a.getElementsByTagName('td')[columnIndex].textContent.toLowerCase();
                    textB = b.getElementsByTagName('td')[columnIndex].textContent.toLowerCase();
                    return textA.localeCompare(textB) * order;
                }
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

        // Function to toggle all checkboxes
        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('#userTableBody .form-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }

        // Add event listener to the "Select All" checkbox
        document.getElementById('selectAll').addEventListener('change', toggleSelectAll);

        function submitDeleteSelected() {
            const checkboxes = document.querySelectorAll('#userTableBody .form-checkbox:checked');
            const selectedIds = Array.from(checkboxes).map(checkbox => checkbox.id);
            document.getElementById('selectedIds').value = JSON.stringify(selectedIds);

            // Submit the form
            document.getElementById('deleteSelectedForm').submit();
        }
    </script>


    @include('users.modals.import-user')

    <!-- Include the Edit User Modal -->
    @include('users.modals.edit-user')

    <!-- Include the Add User Modal -->
    @include('users.modals.add-user')

</x-app-layout>
