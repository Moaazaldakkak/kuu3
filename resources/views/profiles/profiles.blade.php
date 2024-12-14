<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profiles') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <h1 class="text-center mb-4">Profiles</h1>
                    
                    <!-- Profiles Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                        @forelse ($profiles as $profile)
                            
                                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow hover:shadow-lg">
                                    <a href="{{ route('profiles.show', $profile->id) }}" class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow hover:shadow-lg transition duration-200 transform hover:scale-105">
                                        <div>
                                            <img src="{{ $profile->image ? asset($profile->image) : 'https://via.placeholder.com/150' }}" 
                                                alt="{{ $profile->name }}" 
                                                class="w-full h-40 object-cover rounded-t-md mb-4">
                                            <h5 class="text-lg font-semibold text-center mb-2">{{ $profile->name }}</h5>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ $profile->description ?? 'No description provided' }}</p>
                                            <h6 class="text-sm font-bold mb-2">Social Media:</h6>
                                            <ul class="list-disc list-inside text-sm text-gray-500 dark:text-gray-400">
                                                @if (is_array($profile->social_media_accounts))
                                                    @forelse ($profile->social_media_accounts as $account)
                                                        <li>
                                                            <a href="{{ $account['link'] ?? '#' }}" target="_blank" class="text-blue-500 hover:underline">
                                                                {{ $account['platform'] ?? 'Unknown Platform' }}
                                                            </a>
                                                        </li>
                                                    @empty
                                                        <li>No social media accounts available</li>
                                                    @endforelse
                                                @else
                                                    <li>No social media accounts available</li>
                                                @endif
                                            </ul>
                                            <div class="flex justify-between items-center mt-4">
                                                <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this profile?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                       
                        @empty
                            <p class="text-center col-span-full">{{ __("No profiles found!") }}</p>
                        @endforelse
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-6">
                        {{ $profiles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
