<!-- Add User Modal -->
<div id="addTaskModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Add Task
            </h3>
            <form method="POST" action="{{ route('task.store') }}" class="space-y-6">
                @csrf
                <div class="flex gap-4">
                    <div class="w-full">
                        <x-input-label for="name" :value="__('Task Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description"
                              name="description"
                              class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                              rows="4"></textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <div class="flex gap-4">
                    <div class="w-1/3">
                        <x-input-label for="estimation" :value="__('Estimation (hours)')" />
                        <x-text-input id="estimation" name="estimation" type="number" class="mt-1 block w-full" min="0" />
                        <x-input-error class="mt-2" :messages="$errors->get('estimation')" />
                    </div>

                    <div class="w-1/3">
                        <x-input-label for="effort" :value="__('Effort (hours)')" />
                        <x-text-input id="effort" name="effort" type="number" class="mt-1 block w-full" min="0" />
                        <x-input-error class="mt-2" :messages="$errors->get('effort')" />
                    </div>
                    <div class="w-1/3">
                        <x-input-label for="start_date" :value="__('Start Date')" />
                        <x-text-input id="start_date" name="start_date" type="datetime-local" class="mt-1 block w-full" />
                        <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                    </div>
                </div>
                <div class="flex items-center justify-end gap-4">
                    <x-primary-button type="submit">{{ __('Create Task') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAddTaskModal() {
    document.getElementById('addTaskModal').classList.remove('hidden');
}

function closeAddTaskModal() {
    document.getElementById('addTaskModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('addTaskModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddTaskModal();
    }
});

// Prevent modal from closing when clicking inside the modal content
document.querySelector('#addUserModal > div').addEventListener('click', function(e) {
    e.stopPropagation();
});
</script>
