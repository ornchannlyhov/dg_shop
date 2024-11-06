<section>
    <header>
        <h2 class="text-lg font-medium text-dark-900 dark:text-dark-100">
            {{ __('Edit Store') }}
        </h2>

        <p class="mt-1 text-sms" style="color:#94a3b8;">
            {{ __('Update the details of your store below.') }}
        </p>
    </header>

    <form action="{{ route('stores.update', $store->store_id) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="store_name" :value="__('Name')" />
            <x-text-input id="store_name" name="store_name" type="text" class="mt-1 block w-full" value="{{ old('store_name', $store->store_name) }}" required />
            <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="store_description" :value="__('Description')" />
            <textarea id="store_description" name="store_description" class="mt-1 block w-full text-black  border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('store_description', $store->store_description) }}</textarea>
            <x-input-error :messages="$errors->get('store_description')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="logo" :value="__('Logo')" />
            <x-text-input id="logo" name="logo" type="file" class="mt-1 block text-white"/>
            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Update') }}</x-primary-button>
        </div>
    </form>
</section>
