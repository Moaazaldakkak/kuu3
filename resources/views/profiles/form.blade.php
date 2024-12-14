<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $profile->exists ? __('Edit Profile') : __('Create Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form 
                        method="POST" 
                        action="{{ $profile->exists ? route('profiles.update', $profile->id) : route('profiles.store') }}" 
                        class="space-y-6" 
                        enctype="multipart/form-data"
                    >
                        @csrf
                        @if ($profile->exists)
                            @method('PATCH')
                        @endif

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input 
                                id="name" 
                                name="name" 
                                type="text" 
                                class="mt-1 block w-full" 
                                :value="old('name', $profile->name)" 
                                required 
                                autofocus 
                                autocomplete="name" 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea 
                                id="description" 
                                name="description" 
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" 
                                rows="4"
                            >{{ old('description', $profile->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Image -->
                        <div>
                            <x-input-label for="image" :value="__('Profile Image')" />
                            <input 
                                id="image" 
                                name="image" 
                                type="file" 
                                class="mt-1 block w-full text-gray-900 dark:text-gray-100" 
                                accept="image/*" 
                            />
                            @if ($profile->exists && $profile->image)
                                <img 
                                    src="{{ asset($profile->image) }}" 
                                    alt="{{ $profile->name }}" 
                                    class="mt-2 w-24 h-24 rounded-md object-cover"
                                >
                            @endif
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        <!-- Social Media Accounts -->
                        <div>
                            <x-input-label :value="__('Social Media Accounts')" />
                            <div id="social-media-fields" class="space-y-2 mt-2">
                                @forelse ($profile->social_media_accounts ?? [] as $index => $account)
                                    <div class="flex space-x-2">
                                        <x-text-input 
                                            type="text" 
                                            name="social_media_accounts[{{ $index }}][platform]" 
                                            placeholder="Platform (e.g., Twitter)" 
                                            class="flex-1" 
                                            :value="$account['platform'] ?? ''" 
                                        />
                                        <x-text-input 
                                            type="url" 
                                            name="social_media_accounts[{{ $index }}][link]" 
                                            placeholder="Link (e.g., https://twitter.com/example)" 
                                            class="flex-1" 
                                            :value="$account['link'] ?? ''" 
                                        />
                                        <button type="button" class="text-red-500 hover:text-red-700 remove-field">Remove</button>
                                    </div>
                                @empty
                                    <!-- Default Row -->
                                    <div class="flex space-x-2">
                                        <x-text-input 
                                            type="text" 
                                            name="social_media_accounts[0][platform]" 
                                            placeholder="Platform (e.g., Twitter)" 
                                            class="flex-1" 
                                            :value="''" 
                                        />
                                        <x-text-input 
                                            type="url" 
                                            name="social_media_accounts[0][link]" 
                                            placeholder="Link (e.g., https://example.com)" 
                                            class="flex-1" 
                                            :value="''" 
                                        />
                                        <button type="button" class="text-red-500 hover:text-red-700 remove-field">Remove</button>
                                    </div>
                                @endforelse
                            </div>
                            <button 
                                type="button" 
                                id="add-social-media" 
                                class="mt-2 bg-gray-300 dark:bg-gray-700 text-gray-900 dark:text-gray-100 py-1 px-2 rounded"
                            >
                                Add Social Media
                            </button>
                            <x-input-error class="mt-2" :messages="$errors->get('social_media_accounts')" />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center gap-4">
                            <x-primary-button>
                                {{ $profile->exists ? __('Update Profile') : __('Create Profile') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/edit.js'])
    @endpush

</x-app-layout>
