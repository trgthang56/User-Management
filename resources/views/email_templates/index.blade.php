<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Email Template Management') }}
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
                        <form id="deleteSelectedForm" method="POST" action="{{ route('email.template.deleteSelected') }}">
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
                                   placeholder="Search users..."
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-900 dark:text-dark">
                        </div>
                    </div>
                    <!-- Table -->
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" onclick="sortTable('title')">
                                        Title <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" onclick="sortTable('type')">
                                        Type <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" onclick="sortTable('content')">
                                        Content <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" onclick="sortTable('attachment')">
                                        Attachment <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" onclick="sortTable('description')">
                                        Description <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-500" id="userTableBody">
                                @foreach($emailTemplates as $emailTemplate)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-6 py-4 whitespace-wrap">
                                        <input type="checkbox" id="{{ $emailTemplate->id}}" class="form-checkbox">
                                    </td>
                                    <td class="px-6 py-4 whitespace-wrap">
                                        <a href="{{ $emailTemplate->id}}" style="cursor: default;" onclick="event.preventDefault()">
                                            {{ $emailTemplate->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-wrap">
                                        {{ $emailTemplate->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-wrap">
                                        {{ $emailTemplate->type == 0 ? 'Gửi 1 lần' : ($emailTemplate->type == 1 ? 'Gửi theo chu kì' : 'Gửi người đặc biệt') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-wrap">
                                        {{ \Illuminate\Support\Str::limit($emailTemplate->content, 50, '...') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-wrap">
                                        {{ $emailTemplate->attachment ?? 'Không' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-wrap">
                                        {{ $emailTemplate->description ?? 'Không' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('email.template.detail.index', $emailTemplate->id) }}"
                                                class="text-indigo-300 hover:text-indigo-900">
                                                 Detail
                                             </a>
                                             @if(auth()->user()->role == 'admin')
                                            <a href="{{ route('email.template.update.index', $emailTemplate->id) }}"
                                                class="text-indigo-500 hover:text-indigo-900">
                                                 Edit
                                             </a>

                                             <form method="POST" action="{{ route('email.template.delete', $emailTemplate->id) }}" class="inline">
                                                 @csrf
                                                 @method('DELETE')
                                                 <button type="submit"
                                                         class="text-red-600 hover:text-red-900"
                                                         onclick="return confirm('Are you sure you want to delete this template?')">
                                                     Delete
                                                 </button>
                                             </form>
                                             @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    {{-- <div class="mt-4">
                        {{ $users->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Add this script at the bottom of the file -->
    <script>
        function searchUsers() {
            const searchInput = document.getElementById('searchInput');
            const filter = searchInput.value.toLowerCase();
            const tbody = document.getElementById('userTableBody');
            const rows = tbody.getElementsByTagName('tr');

            for (let row of rows) {
                const nameCell = row.getElementsByTagName('td')[1]; // Index 1 là cột Name
                if (nameCell) {
                    const nameText = nameCell.textContent || nameCell.innerText;
                    if (nameText.toLowerCase().indexOf(filter) > -1) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        }
        // Thêm event listener cho input để search khi gõ
        document.getElementById('searchInput').addEventListener('keyup', searchUsers);

        let sortOrder = {
            name: 'asc',
            email: 'asc'
        };

        function sortTable(column) {
            const tbody = document.getElementById('userTableBody');
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

    <!-- Include the Add template Modal -->
    @include('email_templates.modals.add-template')

</x-app-layout>
