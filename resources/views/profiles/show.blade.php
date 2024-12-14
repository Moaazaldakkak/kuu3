<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $profile->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Details -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 flex space-x-6 relative">
                <!-- Edit Button -->
                @auth
                    <a href="{{ route('profiles.edit', $profile->id) }}" 
                        class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6.586-6.586a2 2 0 112.828 2.828L11 13m-1.414 1.414L5 19h4v4l4-4h4l1.414-1.414a2 2 0 00-2.828-2.828L9 11z" />
                        </svg>
                    </a>
                @endauth

                <!-- Profile Image -->
                <div class="w-1/3">
                    <img 
                        src="{{ asset($profile->image) }}" 
                        alt="{{ $profile->name }}" 
                        class="w-full h-auto rounded-md object-cover shadow-lg"
                    >
                    <div class="mt-4 text-gray-600 dark:text-gray-400">
                        <p><strong>Created:</strong> {{ $profile->created_at->format('M d, Y') }}</p>
                        <p><strong>Last Updated:</strong> {{ $profile->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{ $profile->name }}</h1>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">{{ $profile->description }}</p>

                    <!-- Social Media Accounts -->
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Social Media Accounts</h2>
                        <ul class="mt-2 space-y-2">
                            @foreach ($profile->social_media_accounts ?? [] as $account)
                                <li>
                                    <a 
                                        href="{{ $account['link'] }}" 
                                        class="text-blue-500 hover:underline" 
                                        target="_blank" 
                                        rel="noopener noreferrer"
                                    >
                                        {{ $account['platform'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Comments</h2>

                <!-- Comment List -->
                <div id="comments-list" class="space-y-4">
                    @foreach ($profile->comments as $comment)
                        <div id="comment-{{ $comment->id }}" class="border-t border-gray-300 dark:border-gray-700 pt-4">
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                                <div class="flex-1">
                                    @if ($comment->trashed()) <!-- Check if comment is soft-deleted -->
                                        <p class="text-sm italic text-gray-500 dark:text-gray-400">
                                            Comment created on {{ $comment->created_at->format('M d, Y') }} by {{ $comment->user->name }} 
                                            has been deleted on {{ $comment->deleted_at->format('M d, Y') }}.
                                        </p>
                                    @else
                                        <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $comment->user->name }}</h3>
                                        <p class="text-gray-600 dark:text-gray-400">{{ $comment->content }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                                    @endif
                                </div>
                
                                <!-- Delete Button (Visible only to the comment owner if not soft-deleted) -->
                                @if (!$comment->trashed() && auth()->id() === $comment->user_id)
                                    <button 
                                        type="button" 
                                        class="text-red-500 hover:text-red-700 delete-comment" 
                                        data-url="{{ route('profiles.comments.destroy', ['profile' => $profile->id, 'comment' => $comment->id]) }}" 
                                        data-id="{{ $comment->id }}"
                                    >
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
                                        <g>
                                            <path d="M424 64h-88V48c0-26.467-21.533-48-48-48h-64c-26.467 0-48 21.533-48 48v16H88c-22.056 0-40 17.944-40 40v56c0 8.836 7.164 16 16 16h8.744l13.823 290.283C87.788 491.919 108.848 512 134.512 512h242.976c25.665 0 46.725-20.081 47.945-45.717L439.256 176H448c8.836 0 16-7.164 16-16v-56c0-22.056-17.944-40-40-40zM208 48c0-8.822 7.178-16 16-16h64c8.822 0 16 7.178 16 16v16h-96zM80 104c0-4.411 3.589-8 8-8h336c4.411 0 8 3.589 8 8v40H80zm313.469 360.761A15.98 15.98 0 0 1 377.488 480H134.512a15.98 15.98 0 0 1-15.981-15.239L104.78 176h302.44z" fill="#be0000" opacity="1"></path>
                                            <path d="M256 448c8.836 0 16-7.164 16-16V224c0-8.836-7.164-16-16-16s-16 7.164-16 16v208c0 8.836 7.163 16 16 16zM336 448c8.836 0 16-7.164 16-16V224c0-8.836-7.164-16-16-16s-16 7.164-16 16v208c0 8.836 7.163 16 16 16zM176 448c8.836 0 16-7.164 16-16V224c0-8.836-7.164-16-16-16s-16 7.164-16 16v208c0 8.836 7.163 16 16 16z" fill="#be0000" opacity="1"></path>
                                        </g>
                                    </svg>
                                    
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                
                    <!-- If no comments -->
                    @if ($profile->comments->isEmpty())
                        <p id="no-comments" class="text-gray-600 dark:text-gray-400">No comments yet. Be the first to comment!</p>
                    @endif
                </div>
                

                <!-- Comment Form -->
                <div class="mt-6">
                    <form method="POST" action="{{ route('profiles.comments.store', $profile->id) }}">
                        @csrf
                        <textarea 
                            name="content" 
                            rows="4" 
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Add a comment..."
                            required
                        ></textarea>
                        <x-primary-button class="mt-4">Submit Comment</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        @vite(['resources/js/show.js'])
    @endpush

</x-app-layout>
