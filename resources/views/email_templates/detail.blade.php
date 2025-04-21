<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Email Template') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="post"  class="mt-6 space-y-6">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ $emailTemplate->name }}" autofocus disabled/>
                        </div>
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ $emailTemplate->title }}" disabled/>
                        </div>
                        <div>
                            <x-input-label for="type" :value="__('Type')" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" disabled>
                                <option value="">chọn loại</option>
                                <option value="0" {{ $emailTemplate->type == 0 ? 'selected' : '' }}>Gửi 1 lần</option>
                                <option value="1" {{ $emailTemplate->type == 1 ? 'selected' : '' }}>Gửi theo chu kì thông báo task</option>
                                <option value="2" {{ $emailTemplate->type == 2 ? 'selected' : '' }}>Gửi dành riêng một cho người dùng</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="content" :value="__('Content')" />
                            <textarea id="content" name="content" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="4" disabled>{{ $emailTemplate->content }}</textarea>
                        </div>
                        <div>
                            <x-input-label for="attachment" :value="__('Attachment')" />
                            <x-text-input id="attachment" name="attachment" type="file" class="mt-1 block w-full" disabled/>
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="4" disabled>{{ $emailTemplate->description }}</textarea>
                        </div>
                        <div class="flex items-center justify-start gap-4">
                            <x-secondary-button type="button" onclick="window.location.href='{{ route('email.template.list') }}'">back</x-secondary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
