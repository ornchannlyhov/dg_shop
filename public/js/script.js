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
                showMessage(data.message ,'success');
            } else {
                showMessage('Failed to add product to cart.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while adding the product to the cart.','error');
        });
    function showMessage(message, type) {
        var alertClass = type === 'success' ? 'bg-green-500' : 'bg-red-500';
        var alertContainer = $('<div class="alert alert-message text-white ' + alertClass + ' p-4 rounded-lg shadow-md fixed top-10 left-1/2 transform -translate-x-1/2 z-50 w-3/4 md:w-1/3" role="alert"></div>');
        alertContainer.text(message);

        $('body').append(alertContainer);

        setTimeout(function () {
            alertContainer.fadeOut(300, function () {
                alertContainer.remove();
            });
        }, 3000);
    }
}
