<!-- Add User Modal -->
<div id="addUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Add Email Template
            </h3>
            <form method="post" action="{{ route('email.template.store') }}" id="addUserForm" class="mt-6 space-y-6">
                @csrf
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus/>
                </div>
                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required />
                </div>
                <div>
                    <x-input-label for="type" :value="__('Type')" />
                    <select id="type" name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                        <option value="0">Gửi 1 lần</option>
                        <option value="1">Gửi theo chu kì thông báo task</option>
                        <option value="2">Gửi dành riêng một cho người dùng</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="content" :value="__('Content')" />
                    <textarea id="content" name="content" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="4" required ></textarea>
                </div>
                <div>
                    <x-input-label for="attachment" :value="__('Attachment')" />
                    <x-text-input id="attachment" name="attachment" type="file" class="mt-1 block w-full"/>
                </div>
                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="4"></textarea>
                </div>
                <div class="flex items-center justify-end gap-4">
                    <x-secondary-button type="button" onclick="closeAddUserModal()">Cancel</x-secondary-button>
                    <x-primary-button type="submit">{{ __('Add Template') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAddUserModal() {
    document.getElementById('addUserModal').classList.remove('hidden');
}

function closeAddUserModal() {
    document.getElementById('addUserModal').classList.add('hidden');
}

// // Close modal when clicking outside
// document.getElementById('addUserModal').addEventListener('click', function(e) {
//     if (e.target === this) {
//         closeAddUserModal();
//     }
// });

// Prevent modal from closing when clicking inside the modal content
document.querySelector('#addUserModal > div').addEventListener('click', function(e) {
    e.stopPropagation();
});
</script>
