<style>
.custom-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 1000;
    padding: 10px;
}

.custom-modal-content {
    position: absolute; 
    background-color: #3f3f46;
    padding: 20px;
    width: 100%;
    max-width: 494px;
    left: 139px; 
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    max-height: 80%;
    overflow-y: auto;
    transition: all 0.3s ease;
    color: white;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #4a5568;
    padding-bottom: 10px;
}

.modal-body {
    max-height: 400px;
    overflow-y: auto;
    padding-top: 10px;
}

.search-container {
    position: relative;
    width: 100%;
}

.search-container input[type="text"] {
    width: 100%;
    padding: 10px 35px 10px 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    background-color: #fff;
    color: black; 
}

.search-container button {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: black;
    font-size: 16px;
    cursor: pointer;
}

.close {
    font-size: 2rem;
    color: white; 
    cursor: pointer;
    padding: 5px;
    transition: transform 0.3s ease, color 0.3s ease;
}

.close:hover {
    color: #ff4d4d;
    transform: scale(1.2);
}

@media (max-width: 1024px) {
    .custom-modal-content {
        left: 16px; 
        width: calc(100% - 32px); 
        max-width: 100%; 
    }

    .modal-body {
        max-height: 300px;
    }
}

@media (max-width: 768px) {
    .custom-modal-content {
        left: 16px; 
        width: calc(100% - 32px); 
        max-width: 100%; 
    }

    .modal-body {
        max-height: 300px;
    }
}

@media (max-width: 480px) {
    .custom-modal-content {
        left: 8px; 
        width: calc(100% - 16px);
        max-width: 100%; 
        padding: 15px;
    }

    .modal-header {
        font-size: 1rem;
    }

    .close {
        font-size: 1.5rem;
    }
}

.dark .custom-modal-content {
    background-color: #2d3748;
}

.dark .modal-header {
    border-bottom: 1px solid #4a5568;
}

.dark .search-container input[type="text"] {
    background-color: #4a5568;
    color: white;
    border: 1px solid #718096;
}

.dark .close {
    color: #ff4d4d;
}
</style>
<nav x-data="{ open: false }" class="bg-white dark:bg-zinc-900 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center w-full">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('products.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-600" />
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="flex-grow mx-4 ml-2">
                    <form id="searchForm" method="GET" class="relative flex items-center w-full">
                        <div class="search-container">
                            <input id="searchInput" type="text" name="search" placeholder="Search..." 
                                class="form-control rounded border border-gray-30 bg-white text-gray-900 dark:text-gray-200">
                            <button id="searchButton" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                        <i class="fas fa-home mr-2"></i> {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('redirect.toStore')" :active="false">
                        <i class="fas fa-store mr-2"></i> {{ __('My Stores') }}
                    </x-nav-link>
                    <x-nav-link :href="route('userOrderView')" :active="false">
                        <i class="fas fa-box mr-2"></i> {{ __('Orders') }}
                    </x-nav-link>
                    <x-nav-link :href="route('cart.view')" :active="false">
                        <i class="fas fa-shopping-cart mr-2"></i> {{ __('Cart') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-zinc-900 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Profile Link -->
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile Menu) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                <i class="fas fa-home mr-2"></i> {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('redirect.toStore')" :active="false">
                <i class="fas fa-store mr-2"></i> {{ __('My Stores') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('userOrderView')" :active="false">
                <i class="fas fa-box mr-2"></i> {{ __('Orders') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cart.view')" :active="false">
                <i class="fas fa-shopping-cart mr-2"></i> {{ __('Cart') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options (Mobile) -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="custom-modal mt-16" id="searchModal">
        <div class="custom-modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Search Results</h5>
                <button type="button" class="close" id="closeModal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="searchResults">
            </div>
        </div>
    </div>

</nav>


<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const searchModal = $('#searchModal');

        // Show modal when the search input is clicked
        $('#searchInput').on('focus', function() {
            searchModal.show();
        });

        // Fetch results as user types
        $('#searchInput').on('input', function() {
            const searchKeyword = $(this).val().trim();

            if (searchKeyword.length > 1) {
                $.ajax({
                    url: "{{ route('products.search') }}",
                    method: 'GET',
                    data: {
                        search: searchKeyword,
                        categoryId: {{ isset($selectedCategory) ? $selectedCategory->id : 'null' }}
                    },
                    success: function(response) {
                        let resultsHtml = '';

                        if (response.products && response.products.length > 0) {
                            response.products.forEach(product => {
                                resultsHtml += `
                                    <div class="search-result-item">
                                        <a href="/products/${product.id}" class="d-flex align-items-center">
                                            <img src="${product.image_url}" alt="${product.name}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                            <span>${product.name}</span>
                                        </a>
                                    </div>
                                    <hr>
                                `;
                            });
                        } else {
                            resultsHtml = '<p class="text-muted">No results found.</p>';
                        }

                        $('#searchResults').html(resultsHtml); 
                    },
                    error: function() {
                        $('#searchResults').html('<p class="text-danger">Error fetching data.</p>');
                    }
                });
            } else {
                $('#searchResults').html('<p class="text-muted">Start typing to see results...</p>');
            }
        });

        $('#closeModal').on('click', function() {
            searchModal.hide();
        });

        $(window).on('click', function(event) {
            if ($(event.target).is(searchModal)) {
                searchModal.hide();
            }
        });
    });
</script>


