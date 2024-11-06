<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-dark-900 dark:text-dark-100">
            {{ __('Delete Store') }}
        </h2>

        <p class="mt-1 text-sms" style="color:#94a3b8;">
            {{ __('Once your store is deleted, all of its resources and data will be permanently deleted. Before deleting your store, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <!-- Trigger Button -->
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-store-deletion')"
    >{{ __('Delete Store') }}</x-danger-button>

    <!-- Modal -->
    <x-modal name="confirm-store-deletion" :show="$errors->isNotEmpty()" focusable>
        <div x-data="{ open: true }" x-show="open" x-on:open-modal.window="open = true" class="p-6 bg-dark shadow-md rounded-lg max-w-lg mx-auto">
            <form method="post" action="{{ route('stores.destroy', $store->store_id) }}">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-whit">
                    {{ __('Are you sure you want to delete this store?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Once your store is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete this store.') }}
                </p>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="open = false">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Delete Store') }}
                    </x-danger-button>
                </div>
            </form>
        </div>
    </x-modal>
</section>
