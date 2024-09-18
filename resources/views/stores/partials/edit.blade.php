<section>
    <header>
        <h2 class="text-lg font-medium text-dark-900 dark:text-dark-100">
            {{ __('Edit Store') }}
        </h2>

        <p class="mt-1 text-sms" style="color:#94a3b8;">
            {{ __('Update the details of your store below.') }}
        </p>
    </header>

    <form action="{{ route('stores.update', $store->store_id) }}" method="POST" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $store->store_name) }}" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <textarea id="description" name="description" class="mt-1 block w-full text-black  border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $store->store_description) }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Update') }}</x-primary-button>

            @if (session('status') === 'store-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Store updated.') }}</p>
            @endif
        </div>
    </form>
</section>
