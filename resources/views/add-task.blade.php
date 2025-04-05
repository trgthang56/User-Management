<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
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
    </div>
</x-app-layout>
