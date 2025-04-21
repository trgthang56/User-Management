<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex gap-4">
                        <div class="w-full">
                            <x-input-label for="name" :value="__('Task Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $task->name)" required autofocus disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                    </div>
                    <div class="mb-4 mt-4">
                        <x-input-label for="Joined Users" :value="__('Joined')" />
                        <div class="mt-2 flex flex-wrap gap-2">
                            @php
                                $userIds = explode(',', $task->user_id);
                                $assignedUsers = \App\Models\User::whereIn('id', $userIds)->get();
                                $userNames = $assignedUsers->pluck('name')->implode(', ');
                            @endphp
                            <div class="flex items-center gap-2">
                                <span class="text-gray-900 dark:text-gray-100">{{ $userNames }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description"
                                    name="description"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    rows="4" disabled>{{ old('description', $task->description) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div class="flex gap-4">
                        <div class="w-1/4">
                            <x-input-label for="estimation" :value="__('Estimation (hours)')" />
                            <x-text-input id="estimation" name="estimation" type="number" class="mt-1 block w-full" min="0" :value="old('estimation', $task->estimation)" disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('estimation')" />
                        </div>

                        <div class="w-1/4">
                            <x-input-label for="effort" :value="__('Effort (hours)')" />
                            <x-text-input id="effort" name="effort" type="number" class="mt-1 block w-full" min="0" :value="old('effort', $task->effort)" disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('effort')" />
                        </div>
                        <div class="w-1/3">
                            <x-input-label for="start_date" :value="__('Start Date')" />
                            <x-text-input id="start_date" name="start_date" type="datetime-local" class="mt-1 block w-full" :value="old('start_date', $task->start_date->format('Y-m-d\TH:i'))" disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                        </div>
                        <div class="w-1/3">
                            <x-input-label for="end_date" :value="__('End Date')" />
                            <x-text-input id="end_date" name="end_date" type="datetime-local" class="mt-1 block w-full" :value="old('end_date', $task->end_date->format('Y-m-d\TH:i'))" disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-end gap-2">
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
</x-app-layout>
