<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Store') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Success and Error Messages -->
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Store Form -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form action="{{ route('store.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="store_name" :value="__('Store Name')" />
                        <x-text-input id="store_name" name="store_name" type="text" class="mt-1 block w-full" value="{{ old('store_name') }}" required />
                        <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="store_description" :value="__('Store Description')" />
                        <textarea id="store_description" name="store_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('store_description') }}</textarea>
                        <x-input-error :messages="$errors->get('store_description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="logo" :value="__('Store Logo')" />
                        <input id="logo" name="logo" type="file" class="mt-1 block w-full text-sm text-gray-600" />
                        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <x-primary-button>{{ __('Create Store') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
