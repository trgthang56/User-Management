<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Email Campaign') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-start mb-2">
                        <a href="{{ route('email.campaign.list') }}" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-arrow-left text-2xl"></i>
                        </a>
                    </div>
                    <form method="post" class="mt-6 space-y-6">

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" value="{{ $emailCampaign->name }}" disabled/>
                        </div>
                        <div>
                            <x-input-label for="type" :value="__('Type')" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required disabled>
                                <option value="">chọn loại</option>
                                <option value="0" {{ $emailCampaign->type == 0 ? 'selected' : '' }}>Gửi 1 lần</option>
                                <option value="1" {{ $emailCampaign->type == 1 ? 'selected' : '' }}>Gửi theo chu kì thông báo task</option>
                                <option value="2" {{ $emailCampaign->type == 2 ? 'selected' : '' }}>Gửi dành riêng một cho người dùng</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="template_id" :value="__('Template')" />
                            <select id="template_id" name="template_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required disabled>
                                <option value="">chọn template</option>
                                @foreach($emailTemplates as $emailTemplate)
                                    <option value="{{ $emailTemplate->id }}" data-type="{{ $emailTemplate->type }}" {{ $emailCampaign->template_id == $emailTemplate->id ? 'selected' : '' }}>{{ $emailTemplate->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label id="task-label" for="task" :value="__('Task')" style="display: {{ $emailCampaign->type == 1 ? 'block' : 'none' }};" />
                            <div id="task-container" style="display: {{ $emailCampaign->type == 1 ? 'block' : 'none' }};">
                                @foreach($tasks as $task)
                                    @if($task->status == 1)
                                        <div class="flex items-center">
                                            <i class="fas fa-check text-green-500 mr-2"></i>
                                            <label for="task-{{ $task->id }}">{{ $task->name }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" rows="4" disabled>{{ $emailCampaign->description ?? 'Không' }}</textarea>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <x-input-label for="schedule_start" :value="__('Schedule Start')" />
                                <x-text-input id="schedule_start" name="schedule_start" type="datetime-local" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" value="{{ \Carbon\Carbon::parse($emailCampaign->schedule_start)->format('Y-m-d\TH:i') }}" required disabled/>
                            </div>
                            <div class="flex-1">
                                <x-input-label for="schedule_end" :value="__('Schedule End')" />
                                <x-text-input id="schedule_end" name="schedule_end" type="datetime-local" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" value="{{ \Carbon\Carbon::parse($emailCampaign->schedule_end)->format('Y-m-d\TH:i') }}" required disabled/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
