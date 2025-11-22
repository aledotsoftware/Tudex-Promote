<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Creatives') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-end mb-4">
                        <a href="{{ route('creatives.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Add Creative') }}
                        </a>
                    </div>

                    <div class="mt-2 space-y-4">
                        @forelse ($creatives as $creative)
                        <div class="flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-900 rounded-lg">
                            <a href="{{ route('creatives.show', $creative) }}" class="block flex-1 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg p-2">
                                <p class="text-gray-800 dark:text-gray-200">{{ $creative->file_url }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $creative->type }}
                                </p>
                            </a>
                            <div class="flex items-center">
                                <form method="POST" action="{{ route('creatives.toggle-status', $creative) }}" class="mr-4">
                                    @csrf
                                    <button type="submit" class="text-sm font-semibold {{ $creative->is_active ? 'text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-600' : 'text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-600' }}">
                                        {{ $creative->is_active ? __('Pause') : __('Resume') }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('creatives.destroy', $creative) }}" class="ml-4" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600 font-semibold">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                            <p>{{ __("You haven't added any creatives yet.") }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
