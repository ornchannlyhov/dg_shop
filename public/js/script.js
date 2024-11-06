let currentSlide = 0;

function showSlide(index) {
    const slides = document.querySelectorAll('.carousel-item');
    const totalSlides = slides.length;

    if (index >= totalSlides) currentSlide = 0;
    else if (index < 0) currentSlide = totalSlides - 1;
    else currentSlide = index;

    document.querySelector('.carousel-inner').style.transform = `translateX(-${currentSlide * 100}%)`;
}

function nextSlide() {
    showSlide(currentSlide + 1);
}

function prevSlide() {
    showSlide(currentSlide - 1);
}

showSlide(currentSlide);

// This function will be called whenever a product is added to the cart
function addToCart(productId, storeId) {
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ quantity: 1, store_id: storeId })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                fetchCartItems(); // Optionally, call this to update the cart modal.
            } else {
                alert('Failed to add product to cart.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding the product to the cart.');
        });
}

// Fetch cart items when the page loads
window.onload = function () {
    fetchCartItems(); // Fetch cart items from the server
};

function fetchCartItems() {
    $.ajax({
        url: '/cart/items',
        method: 'GET',
        success: function (data) {
            updateCartModal(data.items);
        },
        error: function (xhr, status, error) {
            alert('An error occurred while fetching cart items.');
        }
    });
}

function updateCartModal(cartItems) {
    const cartItemsContainer = document.getElementById('cartItems');
    cartItemsContainer.innerHTML = '';

    if (cartItems.length === 0) {
        cartItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
        return;
    }

    cartItems.forEach(item => {
        cartItemsContainer.innerHTML += `
            <div class="cart-item">
                <img src="${item.product.image_url}" alt="${item.product.name}" />
                <div>
                    <h3>${item.product.name}</h3>
                    <p><strong>Quantity:</strong> ${item.quantity}</p>
                    <p><strong>Price:</strong> $${item.product.price}</p>
                    <button class="quantity-button add" onclick="updateQuantity(${item.product.product_id}, 1)">Add</button>
                    <button class="quantity-button deduct" onclick="updateQuantity(${item.product.product_id}, -1)">Deduct</button>
                </div>
            </div>`;
    });
}

function updateQuantity(productId, change) {
    fetch(`/cart/update/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ change: change })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchCartItems(); // Update the cart items displayed in the modal.
            } else {
                alert('Failed to update cart item.');
            }
        })
        .catch(error => {
            alert('An error occurred while updating the cart item.');
        });
}

function showCartModal() {
    document.getElementById('cartModal').classList.remove('hidden');
}

function closeCartModal() {
    document.getElementById('cartModal').classList.add('hidden');
}
function openCartModal() {
    $.ajax({
        url: '{{ route("cart.items") }}', // Route to fetch cart items
        method: 'GET',
        success: function (data) {
            $('#cart-items').empty(); // Clear existing items
            if (data.items.length > 0) {
                data.items.forEach(item => {
                    $('#cart-items').append(`
                        <li class="list-group-item">
                            ${item.product.name} - ${item.quantity}
                        </li>
                    `);
                });
            } else {
                $('#cart-items').append(`<li class="list-group-item">{{ __('Your cart is empty.') }}</li>`);
            }
            $('#cartModal').modal('show'); // Show the modal
        },
        error: function (xhr) {
            console.error(xhr);
            alert("Error fetching cart items.");
        }
    });
}