<!-- Modal Edit User -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Edit User
            </h3>
            <form method="post" id="editUserForm" class="mt-6 space-y-6">
                @csrf
                @method('patch')
                <input type="hidden" id="userId" name="id">
                <div>
                    <x-input-label for="edit_name" :value="__('Name')" />
                    <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="edit_email" :value="__('Email')" />
                    <x-text-input id="edit_email" name="email" type="email" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
                <div>
                    <x-input-label for="edit_birthday" :value="__('Birthday')" />
                    <x-text-input id="edit_birthday" name="birthday" type="date" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('birthday')" />
                </div>
                <div>
                    <x-input-label for="edit_role" :value="__('Role')" />
                    <select id="edit_role"
                            name="role"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>

                <div class="flex items-center gap-28">
                    <x-secondary-button class="justify-start" type="button" onclick="closeEditModal()">
                        Cancel
                    </x-secondary-button>
                    <x-primary-button  class="justify-end" type="submit">
                        Save Changes
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function openEditModal(id, name, email, role, birthday) {
        document.getElementById('userId').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;
        document.getElementById('edit_birthday').value = birthday;

        const form = document.getElementById('editUserForm');
        form.action = `{{ route('user.update', ':id') }}`.replace(':id', id);

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });

    // Prevent modal from closing when clicking inside the modal content
    document.querySelector('#editModal > div').addEventListener('click', function(e) {
        e.stopPropagation();
    });
</script>