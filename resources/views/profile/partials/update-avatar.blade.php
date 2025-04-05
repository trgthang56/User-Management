<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Ảnh đại diện') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Cập nhật ảnh đại diện") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('profile.updateAvatar') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.updateAvatar') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="avatar" :value="__('Profile Picture')" />

            <!-- Hiển thị ảnh hiện tại -->
            <div class="mt-2">
                @if($user->avatar)
                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center no-image-container">
                        <img src="{{ asset('uploads/' . $user->avatar) }}" alt="Current Avatar" class="w-32 h-32 rounded-full object-cover">
                    </div>
                @else
                    <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center no-image-container">
                        <img src="/template/admin/dist/img/avatar-default.jpg" alt="Default Avatar" class="w-32 h-32 rounded-full object-cover">
                    </div>
                @endif
            </div>

            <!-- Input file cho upload ảnh -->
            <div class="mt-4">
                <input type="file"
                       id="avatar"
                       name="avatar"
                       accept="image/*"
                       class="block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-indigo-50 file:text-indigo-700
                              hover:file:bg-indigo-100"
                       onchange="previewImage(this)" />
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>

            <p class="mt-2 text-sm text-gray-500">
                {{ __('Upload a new profile picture. Recommended size: 200x200 pixels.') }}
            </p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            // Ẩn thẻ "No image" nếu có
            const noImageContainer = document.querySelector('.no-image-container');
            if (noImageContainer) {
                noImageContainer.style.display = 'none';
            }

            // Tạo hoặc cập nhật ảnh preview
            let previewContainer = document.querySelector('.avatar-preview');
            if (!previewContainer) {
                previewContainer = document.createElement('div');
                previewContainer.className = 'mt-2 avatar-preview';
                input.parentElement.parentElement.insertBefore(previewContainer, input.parentElement);
            }

            previewContainer.innerHTML = `
                <img src="${e.target.result}" alt="Preview Avatar" class="w-32 h-32 rounded-full object-cover">
            `;
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>
