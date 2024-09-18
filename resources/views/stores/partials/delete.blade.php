<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-dark-900 dark:text-dark-100">
            {{ __('Delete Store') }}
        </h2>

        <p class="mt-1 text-sms" style="color:#94a3b8;">
            {{ __('Once your store is deleted, all of its resources and data will be permanently deleted. Before deleting your store, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-store-deletion')"
    >{{ __('Delete Store') }}</x-danger-button>

    <x-modal name="confirm-store-deletion" :show="$errors->storeDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('stores.destroy', $store->store_id) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete this store?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your store is deleted, all of its resources and data will be permanently deleted. Please enter your store name to confirm you would like to permanently delete this store.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="store_name":value="$store->store_name" class="sr-only" />

                <x-text-input
                    id="store_name"
                    name="store_name"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Store Name') }}"
                />

                <x-input-error :messages="$errors->storeDeletion->get('store_name')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Store') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
