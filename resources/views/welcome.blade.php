<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Our Online Clothing Store</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    
   
    
   <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #0a1a2a; /* Deep Navy Background */
        color: #d8f3dc; /* Light Cyan Text */
        margin: 0;
        padding: 0;
        line-height: 1.6;
    }
    .navbar {
    width: 100%;
    background-color: #1b3a4b; /* Dark Teal */
    overflow: auto;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    padding: 10px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: fixed; /* Fixed position */
    top: 0; /* Stick to the top */
    left: 0;
    z-index: 1000; /* Ensure it stays above other content */
}

main {
    padding: 100px 20px; /* Add padding to prevent content from being hidden under navbar */
    max-width: 1200px;
    margin: auto;
    background: #102a43; /* Dark Navy Background for main */
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    border-radius: 8px;
}

    
    .navbar {
        width: 100%;
        background-color: #1b3a4b; /* Dark Teal */
        overflow: auto;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .navbar a {
        color: #d8f3dc; /* Light Cyan */
        text-decoration: none;
        font-size: 18px;
        transition: background 0.3s;
        padding: 8px 16px;
    }
    
    .navbar a:hover {
        background-color: #335c67; /* Muted Teal */
    }
    
    .navbar .active {
        background-color: #ff6b6b; /* Bright Coral */
    }
    
    .navbar .search-container {
        display: flex;
        align-items: center;
        margin-left: auto;
    }
    
    .suggestions {
        position: absolute;
        background-color: #1b3a4b; /* Dark Teal */
        color: #d8f3dc; /* Light Cyan Text */
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        border-radius: 4px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        display: none;
    }
    
    .suggestions a {
        display: block;
        padding: 8px 12px;
        color: #d8f3dc; /* Light Cyan Text */
        text-decoration: none;
        font-size: 16px;
    }
    
    .suggestions a:hover {
        background-color: #335c67; /* Muted Teal */
    }
    
    .navbar input[type="text"] {
        padding: 8px 12px;
        border: none;
        border-radius: 4px;
        margin-left: 8px;
        font-size: 16px;
        outline: none;
        background-color: #1b3a4b; /* Dark Teal Background */
        color: #d8f3dc; /* Light Cyan Text */
    }
    
    .navbar input[type="text"]:focus {
        border-color: #ff6b6b; /* Bright Coral Outline on focus */
        outline: none;
    }
    
    @media screen and (max-width: 500px) {
        .navbar a {
            float: none;
            display: block;
            text-align: center;
            padding: 14px 20px;
        }
    
        .navbar .search-container {
            margin-top: 10px;
            width: 100%;
            justify-content: center;
        }
    
        .navbar input[type="text"] {
            width: 100%;
            margin-left: 0;
            margin-top: 8px;
        }
    }
    
    main {
        padding: 50px 20px;
        max-width: 1200px;
        margin: auto;
        background: #102a43; /* Dark Navy Background for main */
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        border-radius: 8px;
    }
    
    h2 {
        font-size: 32px;
        color: #d8f3dc; /* Light Cyan */
        margin-bottom: 30px;
        font-weight: 700;
        text-align: center;
        position: relative;
    }
    
    h2::after {
        content: '';
        width: 60px;
        height: 4px;
        background: #ff6b6b; /* Bright Coral */
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        bottom: -12px;
    }
    
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }
    
    .border {
        padding: 30px;
        background-color: #1b3a4b; /* Dark Teal */
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s, box-shadow 0.3s;
        text-align: center;
    }
    
    .border:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
    }
    
    h3 {
        font-size: 24px;
        margin-bottom: 16px;
        font-weight: 600;
        color: #d8f3dc; /* Light Cyan */
    }
    
    p {
        color: #d8f3dc; /* Light Cyan */
        font-size: 16px;
        line-height: 1.6;
    }
    .product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Smaller minimum width */
    gap: 20px; /* Adjust gap for spacing */
    margin-top: 30px;
}

.product-card {
    background-color: #1b3a4b; /* Dark Teal */
    border-radius: 8px; /* Reduced border radius */
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2); /* Slightly smaller shadow */
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
    text-align: center;
    padding: 15px; /* Reduced padding */
}

.product-card img {
    width: 100%; /* Full width for better display */
    height: auto;
    object-fit: cover;
}

.product-card h3 {
    font-size: 20px; /* Slightly smaller heading */
    color: #d8f3dc; /* Light Cyan */
    margin: 10px 0; /* Reduced margin */
}

.product-card p {
    font-size: 14px; /* Smaller text */
    color: #d8f3dc; /* Light Cyan */
    margin-bottom: 10px;
    padding: 0 10px; /* Reduced padding */
}

.product-card .price {
    font-size: 18px; /* Smaller price text */
    color: #ff6b6b; /* Bright Coral */
    margin-bottom: 10px;
}

.product-card button {
    background-color: #ff6b6b; /* Bright Coral */
    color: #102a43; /* Dark Navy Text */
    border: none;
    padding: 10px 16px; /* Reduced padding */
    border-radius: 5px;
    font-size: 14px; /* Smaller button text */
    cursor: pointer;
    transition: background-color 0.3s;
    margin-bottom: 15px;
}

.product-card button:hover {
    background-color: #e05d5d; /* Darker Coral on hover */
}

@media screen and (max-width: 500px) {
    .product-grid {
        grid-template-columns: repeat(2, 1fr); /* Display 2 items per row on phones */
        gap: 10px; /* Reduce gap on small screens */
    }
}     
.product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
    }
    
    .product-card img {
        width: 70%;
        height: auto;
        object-fit: cover;
    }
    
    .product-card h3 {
        font-size: 22px;
        color: #d8f3dc; /* Light Cyan */
        margin: 15px 0;
    }
    
    .product-card p {
        font-size: 16px;
        color: #d8f3dc; /* Light Cyan */
        margin-bottom: 15px;
        padding: 0 15px;
    }
    
    .product-card .price {
        font-size: 20px;
        color: #ff6b6b; /* Bright Coral */
        margin-bottom: 15px;
    }
    
    .product-card button {
        background-color: #ff6b6b; /* Bright Coral */
        color: #102a43; /* Dark Navy Text */
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-bottom: 20px;
    }
    
    .product-card button:hover {
        background-color: #e05d5d; /* Darker Coral on hover */
    }

    
    footer {
        background-color: #1b3a4b; /* Dark Teal */
        color: #d8f3dc; /* Light Cyan */
        text-align: center;
        padding: 30px;
        font-size: 16px;
        margin-top: 50px;
        border-top: 4px solid #ff6b6b; /* Bright Coral Top Border */
    }
    
    footer a {
        color: #ff6b6b; /* Bright Coral */
        text-decoration: none;
        font-weight: 500;
        transition: text-decoration 0.3s;
    }
    
    footer a:hover {
        text-decoration: underline;
    }
    
    /* Notification Styles */
    .notification {
        display: none;
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #4CAF50; /* Green for success notification */
        color: white;
        padding: 16px;
        border-radius: 5px;
        z-index: 1000;
    }
    
   </style>
   
    
      
</head>
<body>
    <!-- Header -->
    <div class="navbar">
        <a class="active" href="#"><i class="fa fa-fw fa-home"></i> Home</a>
        <a href="#"><i class="fa fa-fw fa-envelope"></i> Contact</a>
        <a href="#"><i class="fa fa-fw fa-user"></i> Login</a>
       
      
        <div class="search-container">
           
           
            <a href="#"><i class="fa fa-fw fa-search"></i></a>
            <input type="text" id="product-search" placeholder="Search products...">
            <div id="search-suggestions" class="suggestions"></div> <!-- New div for suggestions -->
            <button> <svg xmlns="http://www.w3.org/2000/svg"  button:hover=" #335c67" width="20" height="20" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16" background-color="blue">
                <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z"/>
                
              </svg></button>
        </div>
        
        
    </div>

    <!-- Slide bar -->
    <div class="w3-content w3-section" style="max-width:700px; margin: 40px auto;">
        <p>Discover our latest collections with amazing deals and discounts.</p>
        <img class="mySlides w3-animate-fading" src="http://t3.gstatic.com/licensed-image?q=tbn:ANd9GcTVMS9-4HlD7Xk7a8xgT4WBQGv8D1zNAglk_kWBHv10LPhY9ESChgCxC011OMjlfcRIkmLCu46bYf5u3sl-ZHU" style="width:100%">
        <img class="mySlides w3-animate-fading" src="http://t3.gstatic.com/licensed-image?q=tbn:ANd9GcR039MAfWG3td_9v81sSEYn8U_bdlYuBQ1Gu2WawMolb82IHJUnIMY8Nob-lkyDe6bm-Nl8ozHsADKayLvYnKM" style="width:100%">
        <img class="mySlides w3-animate-fading" src="http://t3.gstatic.com/licensed-image?q=tbn:ANd9GcQAgfBNw6-wqxp06D8djsYPnrWpVQfsY5IUvEoqKxI5tLd5Krznqd4_ZdGXAKsQtn44nP_CZBE_IjACD_D8jZw" style="width:100%">
        <img class="mySlides w3-animate-fading" src="http://t0.gstatic.com/licensed-image?q=tbn:ANd9GcQaML4nz1GoCOWzNpV6zImsgKjF4TGIprIyxsEv9hwTouMnjYVuLzdd73zTXQuWHYZcQXX06NhuWocnocLqps4" style="width:100%">
    </div>

    <!-- Categories Section -->
    <main>
        <h2>Categories</h2>
        <div class="grid">
            <div class="border">
                <h3>Men's Clothing</h3>
                <p>Explore a wide range of men's clothing including shirts, pants, and jackets.</p>
            </div>
            <div class="border">
                <h3>Women's Clothing</h3>
                <p>Discover the latest trends in women's fashion including dresses, tops, and more.</p>
            </div>
            <div class="border">
                <h3>Kids' Clothing</h3>
                <p>Find fun and stylish clothing options for kids of all ages.</p>
            </div>
        </div>

        <!-- Product Section -->
        <h2>Featured Products</h2>
        <div class="product-grid" id="product-list">
            <div class="product-card" data-name="Stylish Men's Jacket">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_LKPI7Ts3G0QP5T65x5vrupH5uybhPSK7uQ&s" alt="Product 1">
                <h3>Stylish Men's Jacket</h3>
                <p>A premium quality men's jacket perfect for the winter season.</p>
                <p class="price">$99.99</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card" data-name="Women's Summer Dress">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_LKPI7Ts3G0QP5T65x5vrupH5uybhPSK7uQ&s" alt="Product 2">
                <h3>Women's Summer Dress</h3>
                <p>Light and breezy dress ideal for summer days.</p>
                <p class="price">$79.99</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card" data-name="Kids' Fun T-Shirt">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_LKPI7Ts3G0QP5T65x5vrupH5uybhPSK7uQ&s" alt="Product 3">
                <h3>Kids' Fun T-Shirt</h3>
                <p>Cute and comfortable t-shirt for kids.</p>
                <p class="price">$29.99</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card" data-name="Stylish Men's Jacket">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_LKPI7Ts3G0QP5T65x5vrupH5uybhPSK7uQ&s" alt="Product 1">
                <h3>Stylish Men's Jacket</h3>
                <p>A premium quality men's jacket perfect for the winter season.</p>
                <p class="price">$99.99</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card" data-name="Women's Summer Dress">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_LKPI7Ts3G0QP5T65x5vrupH5uybhPSK7uQ&s" alt="Product 2">
                <h3>Women's Summer Dress</h3>
                <p>Light and breezy dress ideal for summer days.</p>
                <p class="price">$79.99</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card" data-name="Kids' Fun T-Shirt">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_LKPI7Ts3G0QP5T65x5vrupH5uybhPSK7uQ&s" alt="Product 3">
                <h3>Kids' Fun T-Shirt</h3>
                <p>Cute and comfortable t-shirt for kids.</p>
                <p class="price">$29.99</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card" data-name="Stylish Men's Jacket">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_LKPI7Ts3G0QP5T65x5vrupH5uybhPSK7uQ&s" alt="Product 1">
                <h3>Stylish Men's Jacket</h3>
                <p>A premium quality men's jacket perfect for the winter season.</p>
                <p class="price">$99.99</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card" data-name="Women's Summer Dress">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_LKPI7Ts3G0QP5T65x5vrupH5uybhPSK7uQ&s" alt="Product 2">
                <h3>Women's Summer Dress</h3>
                <p>Light and breezy dress ideal for summer days.</p>
                <p class="price">$79.99</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card" data-name="Kids' Fun T-Shirt">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_LKPI7Ts3G0QP5T65x5vrupH5uybhPSK7uQ&s" alt="Product 3">
                <h3>Kids' Fun T-Shirt</h3>
                <p>Cute and comfortable t-shirt for kids.</p>
                <p class="price">$29.99</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card" data-name="Stylish Men's Jacket">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_LKPI7Ts3G0QP5T65x5vrupH5uybhPSK7uQ&s" alt="Product 1">
                <h3>Stylish Men's Jacket</h3>
                <p>A premium quality men's jacket perfect for the winter season.</p>
                <p class="price">$99.99</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card" data-name="Women's Summer Dress">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_LKPI7Ts3G0QP5T65x5vrupH5uybhPSK7uQ&s" alt="Product 2">
                <h3>Women's Summer Dress</h3>
                <p>Light and breezy dress ideal for summer days.</p>
                <p class="price">$79.99</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card" data-name="Kids' Fun T-Shirt">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_LKPI7Ts3G0QP5T65x5vrupH5uybhPSK7uQ&s"  alt="Product 3">
                <h3>Kids' Fun T-Shirt</h3>
                <p>Cute and comfortable t-shirt for kids.</p>
                <p class="price">$29.99</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card" data-name="Stylish Men's Jacket">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_LKPI7Ts3G0QP5T65x5vrupH5uybhPSK7uQ&s" alt="Product 1">
                <h3>Stylish Men's Jacket</h3>
                <p>A premium quality men's jacket perfect for the winter season.</p>
                <p class="price">$99.99</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card" data-name="Women's Summer Dress">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_LKPI7Ts3G0QP5T65x5vrupH5uybhPSK7uQ&s" alt="Product 2">
                <h3>Women's Summer Dress</h3>
                <p>Light and breezy dress ideal for summer days.</p>
                <p class="price">$79.99</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
            <div class="product-card" data-name="Kids' Fun T-Shirt">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_LKPI7Ts3G0QP5T65x5vrupH5uybhPSK7uQ&s" alt="Product 3">
                <h3>Kids' Fun T-Shirt</h3>
                <p>Cute and comfortable t-shirt for kids.</p>
                <p class="price">$29.99</p>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>

        <!-- User Shop Creation Section -->
        <div class="mt-8">
            <h2>Create Your Own Shop</h2>
            <p>Want to sell your products? <a href="#" class="text-blue-500">Sign up</a> to create your own shop!</p>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Clothing Store. All rights reserved.</p>
        <p><a href="#">Contact Us</a></p>
    </footer>

    <!-- Notification -->
    <div class="notification" id="notification">Product added to cart!</div>

    <script>
        // Carousel functionality
        var myIndex = 0;
        function carousel() {
            var i;
            var x = document.getElementsByClassName("mySlides");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            myIndex++;
            if (myIndex > x.length) { myIndex = 1 }
            x[myIndex - 1].style.display = "block";
            setTimeout(carousel, 6000); // Change image every 6 seconds
        }
        carousel();

        // Search functionality
        document.getElementById('product-search').addEventListener('input', function () {
            var filter = this.value.toUpperCase();
            var products = document.getElementById("product-list").getElementsByClassName('product-card');
            for (var i = 0; i < products.length; i++) {
                var productName = products[i].getAttribute('data-name');
                if (productName.toUpperCase().indexOf(filter) > -1) {
                    products[i].style.display = "";
                } else {
                    products[i].style.display = "none";
                }
            }
        });

        // Add to cart functionality
        var addToCartButtons = document.getElementsByClassName('add-to-cart');
        for (var i = 0; i < addToCartButtons.length; i++) {
            addToCartButtons[i].addEventListener('click', function () {
                var notification = document.getElementById('notification');
                notification.style.display = 'block';
                setTimeout(function () {
                    notification.style.display = 'none';
                }, 3000);
            });
        }

     // Search functionality with suggestions
document.getElementById('product-search').addEventListener('input', function () {
    var filter = this.value.toUpperCase();
    var products = document.getElementById("product-list").getElementsByClassName('product-card');
    var suggestions = document.getElementById('search-suggestions');
    suggestions.innerHTML = ''; // Clear previous suggestions
    suggestions.style.display = 'none'; // Hide suggestions by default
    let firstMatch = null; // Variable to store the first matching product

    if (filter.length > 0) {
        for (var i = 0; i < products.length; i++) {
            var productName = products[i].getAttribute('data-name');
            if (productName.toUpperCase().indexOf(filter) > -1) {
                // Create a suggestion link
                var suggestionItem = document.createElement('a');
                suggestionItem.textContent = productName;
                suggestionItem.href = "#"; // Modify to redirect to the product page if needed
                
                // When a suggestion is clicked
                suggestionItem.addEventListener('click', (function(name) {
                    return function() {
                        // Set the input value to suggestion
                        document.getElementById('product-search').value = name;
                        suggestions.style.display = 'none'; // Hide suggestions
                    }
                })(productName)); // Using closure to capture 'productName'
                
                suggestions.appendChild(suggestionItem);
                suggestions.style.display = 'block'; // Show suggestions
                
                // Store the first matching product for scrolling
                if (!firstMatch) {
                    firstMatch = products[i]; // Set the first matching product
                }
            }
        }
    }

    // If there's a first matching product, scroll to it automatically
    if (firstMatch) {
        firstMatch.scrollIntoView({ behavior: 'smooth', block: 'nearest' }); // Scroll to the product
    }
});

// Hide suggestions when clicking outside the search bar
document.addEventListener('click', function(event) {
    var isClickInside = document.getElementById('product-search').contains(event.target) ||
                        document.getElementById('search-suggestions').contains(event.target);
    if (!isClickInside) {
        document.getElementById('search-suggestions').style.display = 'none';
    }
});

    </script>
</body>
</html>
