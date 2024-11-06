<x-app-layout>
    <div class="container mx-auto p-6 space-y-8">

        <!-- Hot Selling Products Slideshow -->
        <section class="carousel-container">
            <h1 class="text-2xl font-bold mb-4">Hot Selling Products</h1>
            <div class="carousel-inner">
                @foreach ($products as $product)
                    <div class="carousel-item">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        <div class="carousel-overlay">
                            <h2 class="text-3xl font-bold mb-2">{{ $product->name }}</h2>
                            <p class="text-lg mb-4">{{ $product->description }}</p>
                            <p class="text-xl font-semibold mb-4">${{ number_format($product->price, 2) }}</p>
                            <button onclick="addToCart({{ $product->product_id }}, {{ $product->store_id }})" class="custom-button">Add to Cart</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control left" onclick="prevSlide()">&#10094;</button>
            <button class="carousel-control right" onclick="nextSlide()">&#10095;</button>
        </section>

        <!-- Special Offers -->
        <section class="section">
            <h1>Special Offers</h1>
            <div class="product-grid">
                @foreach ($products as $product)
                    <a href="{{ route('products.show', $product->product_id) }}" class="product-card">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        <div class="content">
                            <h2>{{ $product->name }}</h2>
                            <p>{{ $product->description }}</p>
                            <p class="price">${{ number_format($product->price, 2) }}</p>
                            <button onclick="event.preventDefault(); addToCart({{ $product->product_id }}, {{ $product->store_id }});" class="custom-button">Add to Cart</button>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- Recent Products -->
        <section class="section">
            <h1>Recent Products</h1>
            <div class="product-grid">
                @foreach ($products as $product)
                    <a href="{{ route('products.show', $product->product_id) }}" class="product-card">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        <div class="content">
                            <h2>{{ $product->name }}</h2>
                            <p>{{ $product->description }}</p>
                            <p class="price">${{ number_format($product->price, 2) }}</p>
                            <button onclick="event.preventDefault(); addToCart({{ $product->product_id }}, {{ $product->store_id }});" class="custom-button">Add to Cart</button>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- Cart Modal -->
        <div id="cartModal" class="modal hidden">
            <div class="modal-content">
                <span class="close" onclick="closeCartModal()">&times;</span>
                <h2>Your Cart</h2>
                <div id="cartItems"></div>
                <button id="checkoutButton" class="custom-button mt-4">Checkout</button>
            </div>
        </div>
    </div>
</x-app-layout>
