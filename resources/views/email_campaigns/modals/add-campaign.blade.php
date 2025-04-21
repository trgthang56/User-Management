<!-- Add Campaign Modal -->
<div id="addCampaignModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 w-1/3 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Add Email Campaign
            </h3>
            <form method="post" action="{{ route('email.campaign.store') }}" id="addUserForm" class="mt-6 space-y-6">
                @csrf
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus/>
                </div>
                <div>
                    <x-input-label for="type" :value="__('Type')" />
                    <select id="type" name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                        <option value="">chọn loại</option>
                        <option value="0">Gửi 1 lần</option>
                        <option value="1">Gửi theo chu kì thông báo task</option>
                        <option value="2">Gửi dành riêng một cho người dùng</option>
                    </select>
                </div>
                <div>
                    <x-input-label for="template_id" :value="__('template')" />
                    <select id="template_id" name="template_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                        <option value="">chọn template</option>
                        @foreach($emailTemplates as $emailTemplate)
                            <option value="{{ $emailTemplate->id }}" data-type="{{ $emailTemplate->type }}">{{ $emailTemplate->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <x-input-label id="task-label" for="task" :value="__('Task')" style="display: none;" />
                    <div id="task-container" style="display: none;">
                        @foreach($tasks as $task)
                            @if($task->status == 1)
                                <div class="flex items-center">
                                    <input type="checkbox" id="task-{{ $task->id }}" name="task[]" value="{{ $task->id }}" class="mr-2">
                                    <label for="task-{{ $task->id }}">{{ $task->name }}</label>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="4"></textarea>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex-1">
                        <x-input-label for="schedule_start" :value="__('Schedule Start')" />
                        <x-text-input id="schedule_start" name="schedule_start" type="datetime-local" class="mt-1 block w-full" required />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="schedule_end" :value="__('Schedule End')" />
                        <x-text-input id="schedule_end" name="schedule_end" type="datetime-local" class="mt-1 block w-full" required />
                    </div>
                </div>


                <div class="flex items-center justify-end gap-4">
                    <x-secondary-button type="button" onclick="closeAddUserModal()">Cancel</x-secondary-button>
                    <x-primary-button type="submit">{{ __('Add Campaign') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAddCampaignModal() {
        document.getElementById('addCampaignModal').classList.remove('hidden');
    }

    function closeAddCampaignModal() {
        document.getElementById('addCampaignModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('addCampaignModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAddCampaignModal();
        }
    });

    // Prevent modal from closing when clicking inside the modal content
    document.querySelector('#addCampaignModal > div').addEventListener('click', function(e) {
        e.stopPropagation();
    });
</script>

<script>
    // Set minimum date for schedule_start to current date/time
    const startInput = document.getElementById('schedule_start');
    const now = new Date();
    startInput.min = now.toISOString().slice(0, 16);

    // Add event listener for schedule_start
    startInput.addEventListener('change', function() {
        const startDate = new Date(this.value);
        const endInput = document.getElementById('schedule_end');

        // Set minimum date for schedule_end to start date
        endInput.min = this.value;

        // If current end date is before start date, update it
        const endDate = new Date(endInput.value);
        if (endDate < startDate) {
            startDate.setHours(startDate.getHours() + 1);
            endInput.value = startDate.toISOString().slice(0, 16);
        }
    });

    // Add event listener for schedule_end
    document.getElementById('schedule_end').addEventListener('change', function() {
        const endDate = new Date(this.value);
        const startDate = new Date(startInput.value);

        if (endDate < startDate) {
            alert('End date must be after start date');
            startDate.setHours(startDate.getHours() + 1);
            this.value = startDate.toISOString().slice(0, 16);
        }
    });
</script>

<script>
    document.getElementById('type').addEventListener('change', function() {
        const selectedType = this.value;
        const templateSelect = document.getElementById('template_id');
        const taskContainer = document.getElementById('task-container');
        const taskLabel = document.getElementById('task-label');
        const options = templateSelect.querySelectorAll('option');

        // Filter templates based on selected type
        options.forEach(option => {
            if (option.value === "") {
                option.style.display = 'block'; // Always show the default "chọn template" option
            } else {
                const type = option.getAttribute('data-type');
                if (type === selectedType || selectedType === "") {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            }
        });

        // Reset the selected option to the default
        templateSelect.value = "";

        // Show or hide the task checkboxes based on the selected type
        if (selectedType === "1") {
            taskContainer.style.display = 'block';
            taskLabel.style.display = 'block';
        } else {
            taskContainer.style.display = 'none';
            taskLabel.style.display = 'none';
        }
    });
</script>
