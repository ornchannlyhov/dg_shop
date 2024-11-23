<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Your Cart</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="dark:bg-zinc-900 text-white">

    <div class="container mx-auto p-8">
        <h2 class="text-3xl font-semibold text-center mb-8">Your Cart</h2>

        @if($carts && $carts->count() > 0)
            @foreach($carts as $cart)
                <div class="bg-zinc-700 p-6 mb-8 rounded-lg shadow-lg" id="cart-{{ $cart->cart_id }}">
                    <!-- Store Name -->
                    <h4 class="text-lg font-medium mb-4">Cart for Store: {{ $cart->store->store_name }}</h4>

                    <!-- Cart Items -->
                    @foreach($cart->items as $cartItem)
                        <div class="flex items-center mb-4" id="cart-item-{{ $cartItem->cart_item_id }}">
                            <!-- Product Image -->
                            <img src="{{ $cartItem->product->image_url }}" alt="{{ $cartItem->product->name }}"
                                class="w-20 h-20 object-cover rounded-lg">

                            <!-- Product Info -->
                            <div class="ml-4 flex-grow">
                                <p class="font-bold">{{ $cartItem->product->name }}</p>
                                <p class="text-gray-400">Price: ${{ $cartItem->product->price }}</p>
                                <p class="text-gray-400">Quantity: <span
                                        id="quantity-{{ $cartItem->cart_item_id }}">{{ $cartItem->quantity }}</span></p>
                                <p class="text-gray-300">Total: $<span
                                        id="total-price-{{ $cartItem->cart_item_id }}">{{ $cartItem->quantity * $cartItem->product->price }}</span>
                                </p>
                            </div>

                            <!-- Increase and Decrease Buttons (Placed on the right) -->
                            <div class="ml-4 flex items-center space-x-4">
                                <button
                                    class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition duration-300 update-quantity"
                                    data-change="1" data-cart-item-id="{{ $cartItem->cart_item_id }}">+</button>
                                <button
                                    class="bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600 transition duration-300 update-quantity"
                                    data-change="-1" data-cart-item-id="{{ $cartItem->cart_item_id }}">-</button>
                            </div>
                        </div>
                    @endforeach

                    <!-- Order Button -->
                    <button type="button" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 ml-auto block"
                        id="orderButton">
                        Order
                    </button>
                </div>
            @endforeach
        @else
            <p class="text-center text-lg mt-8">Your cart is empty.</p>
        @endif
    </div>
    <!-- Modal -->
    <div id="orderModal"
        class="fixed inset-0 flex justify-center items-center bg-gray-600 bg-opacity-50 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-zinc-700 p-6 rounded-lg w-96">
            <h2 class="text-2xl font-semibold mb-4 text-white">Order Details</h2>

            @if($carts && $carts->count() > 0)
                    <div class="text-white">
                        <p><strong>Store:</strong> {{ $cart->store->store_name }}</p>
                        <p><strong>Total Amount:</strong> ${{ $cart->items->sum(fn($item) => $item->product->price *
                $item->quantity) }}</p>
                    </div>
            @else
                <div class="text-white">
                    <p><strong>Your cart is empty</strong></p>
                    <p class="text-gray-400">No items to checkout, but you can explore our products.</p>
                </div>
            @endif

            <div class="mt-6 text-white">
                <p class="font-semibold">Select Payment Method:</p>
                <div class="payment-method-options">
                    <label>
                        <input type="radio" name="paymentMethod" value="stripe"> Stripe
                    </label>
                    <label>
                        <input type="radio" name="paymentMethod" value="aba"> ABA Bank
                    </label>
                    <label>
                        <input type="radio" name="paymentMethod" value="cash_on_delivery"> Cash on Delivery
                    </label>
                </div>
            </div>

            <div id="stripeForm" class="mt-4 hidden">
                <h3 class="font-semibold text-white">Stripe Payment</h3>
                <p class="text-white">Enter your payment details to complete the payment.</p>
                <button class="bg-blue-500 text-white px-6 py-2 mt-4 rounded-lg">Pay with Stripe</button>
            </div>

            <div id="abaForm" class="mt-4 hidden">
                <h3 class="font-semibold text-white">ABA Bank Payment</h3>
                <p class="text-white">ABA payment processing instructions.</p>
                <button class="bg-blue-500 text-white px-6 py-2 mt-4 rounded-lg">Pay with ABA</button>
            </div>

            <div id="cashOnDeliveryForm" class="mt-4 hidden">
                <h3 class="font-semibold text-white">Cash on Delivery</h3>
                <p class="text-white">You will pay cash upon delivery.</p>
                <button class="bg-blue-500 text-white px-6 py-2 mt-4 rounded-lg">Confirm Order</button>
            </div>

            <!-- Modal Buttons -->
            <div class="flex justify-end mt-6">
                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-2"
                    id="cancelButton">Cancel</button>
                <button type="button" class="bg-green-500 text-white px-6 py-2 rounded-lg" id="confirmButton"
                    onclick="confirmOrder()" disabled>Confirm Order</button>
            </div>
        </div>
    </div>

    </div>

    <script>
        $(document).ready(function () {
            // Handle Quantity Update
            $('.update-quantity').click(function () {
                var cartItemId = $(this).data('cart-item-id');
                var change = $(this).data('change');
                var quantityElement = $('#quantity-' + cartItemId);
                var totalPriceElement = $('#total-price-' + cartItemId);

                $.ajax({
                    url: '{{ url("/cart/update") }}/' + cartItemId,
                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        change: change
                    },
                    success: function (response) {
                        if (response.success) {
                            quantityElement.text(response.quantity);
                            totalPriceElement.text(response.total_price);

                            if (response.removed) {
                                $('#cart-item-' + cartItemId).remove();
                            }

                            if (response.cartRemoved) {
                                $('#cart-' + response.cartId).remove();
                            }
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        alert('An error occurred. Please try again.');
                    }
                });
            });

            // Show Modal on Order Button Click
            $('#orderButton').click(function () {
                $('#orderModal').removeClass('hidden').addClass('opacity-100');
            });

            // Cancel Button in Modal
            $('#cancelButton').click(function () {
                $('#orderModal').addClass('opacity-0');
                setTimeout(() => $('#orderModal').addClass('hidden'), 300);
            });

            // Payment Method Selection
            $('input[name="paymentMethod"]').change(function () {
                var paymentMethod = $(this).val();
                $('#stripeForm, #abaForm, #cashOnDeliveryForm').addClass('hidden');
                $('#confirmButton').prop('disabled', false);

                if (paymentMethod === 'stripe') {
                    $('#stripeForm').removeClass('hidden');
                } else if (paymentMethod === 'aba') {
                    $('#abaForm').removeClass('hidden');
                } else if (paymentMethod === 'cash_on_delivery') {
                    $('#cashOnDeliveryForm').removeClass('hidden');
                }
            });
        });

        function confirmOrder() {
            const selectedPaymentMethod = document.querySelector('input[name="paymentMethod"]:checked');

            if (!selectedPaymentMethod) {
                alert('Please select a payment method.');
                return;
            }

            const paymentMethod = selectedPaymentMethod.value;

            const formData = new FormData();
            formData.append('payment_method', paymentMethod);
            formData.append('_token', '{{ csrf_token() }}');

            // Perform the checkout request via AJAX
            $.ajax({
                url: '{{ route('order.checkout') }}',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        window.location.href = response.redirect_url;
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('An error occurred during checkout. Please try again.');
                }
            });
        }

    </script>

</body>

</html>