<!-- resources/views/welcome.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Our Online Clothing Store</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<style>

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f9f9f9;
    color: #444;
    margin: 0;
    padding: 0;
    line-height: 1.6;
}

/* Header Styles */
header {
    background: linear-gradient(90deg, #1c1c1c, #444);
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
#loginBtn {
  text-white;
  hover:underline; /* Existing hover effect */
}
#loginBtn {
  text-white;
  /* Add background color on hover */
  background-color: #f9f9f9;
  transition: background-color 0.3s ease;
  hover:underline;
  hover:bg-gray-200; /* New hover effect with background color */
}


header img {
    height: 50px;
    margin-right: 10px;
}

header h1 {
    font-size: 28px;
    font-weight: bold;
    margin: 0;
    text-align: center
}

header a {
    color: white;
    text-decoration: none;
    font-size: 18px;
    padding: 8px 12px;
    border-radius: 4px;
    transition: background 0.3s ease;
}

header a:hover {
    background-color: #ff6347;
}

/* Main Content Styles */
main {
    padding: 40px;
    max-width: 1200px;
    margin: auto;
}

h2 {
    font-size: 36px;
    color: #333;
    margin-bottom: 20px;
    font-weight: 700;
    position: relative;
}

h2::after {
    content: '';
    width: 60px;
    height: 4px;
    background: #ff6347;
    position: absolute;
    left: 0;
    bottom: -8px;
}

.grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.border {
    border: 1px solid #ddd;
    padding: 24px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.border:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
}

h3 {
    font-size: 22px;
    margin-bottom: 12px;
    font-weight: 600;
    color: #222;
}

p {
    margin: 0;
    color: #666;
    font-size: 16px;
}

/* Form Styles */
input[type="text"] {
    width: 100%;
    padding: 14px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: border-color 0.3s ease;
}

input[type="text"]:focus {
    border-color: #ff6347;
    outline: none;
}

/* Footer Styles */
footer {
    background-color: #1c1c1c;
    color: white;
    text-align: center;
    padding: 20px;
    margin-top: 50px;
    font-size: 16px;
}

footer a {
    color: #ff6347;
    text-decoration: none;
    font-weight: 500;
}

footer a:hover {
    text-decoration: underline;
}


</style>
<body>
    <!-- Header -->
    <header class="bg-gray-800 text-white p-4 flex justify-between items-center">
        <div class="flex items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 mr-2">
            <h1 class="text-2xl">Clothing Store</h1>
        </div>
        <div class="flex space-x-4">
            <a href="#" class="text-white hover:underline">Home</a>
            <a href="#" class="text-white hover:underline">Shop</a>
            <a href="#" class="text-white hover:underline">Contact Us</a>
            <a href="{{ route('Loinginpage') }}" class="text-white hover:underline">Login</a>
            <a href="#" class="text-white hover:underline">Create a shop</a>
           
        </div>
    </header>
    <!-- Categories Section -->
    <main class="p-6">
        <h2 class="text-3xl font-bold mb-4">Categories</h2>
        <div class="grid grid-cols-3 gap-4">
            <div class="border p-4">
                <h3 class="font-semibold">Men's Clothing</h3>
                <p>Explore a wide range of men's clothing including shirts, pants, and jackets.</p>
            </div>
            <div class="border p-4">
                <h3 class="font-semibold">Women's Clothing</h3>
                <p>Discover the latest trends in women's fashion including dresses, tops, and more.</p>
            </div>
            <div class="border p-4">
                <h3 class="font-semibold">Kids' Clothing</h3>
                <p>Find fun and stylish clothing options for kids of all ages.</p>
            </div>
        </div>

        <!-- User Shop Creation Section -->
        <div class="mt-8">
            <h2 class="text-3xl font-bold mb-4">Create Your Own Shop</h2>
            <p>Want to sell your products? <a href="#" class="text-blue-500">Sign up</a> to create your own shop!</p>
        </div>

        <!-- Search Shop and Product Section -->
        <div class="mt-8">
            <h2 class="text-3xl font-bold mb-4">Search</h2>
            <div class="mb-4">
                <label for="shop-search" class="block mb-1">Search Shops:</label>
                <input type="text" id="shop-search" placeholder="Enter shop name" class="border p-2 w-full">
            </div>
            <div>
                <label for="product-search" class="block mb-1">Search Products:</label>
                <input type="text" id="product-search" placeholder="Enter product name" class="border p-2 w-full">
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-4 text-center">
        <p>&copy; 2024 Clothing Store. All rights reserved.</p>
        <p><a href="#" class="text-white underline">Contact Us</a></p>
    </footer>

    <script >// app.js

       // app.js
       document.addEventListener('DOMContentLoaded', function () {
  const loginBtn = document.getElementById('loginBtn');
  const loginDropdown = document.getElementById('loginDropdown');

  // Toggle dropdown visibility on button click or hover
  loginBtn.addEventListener('click', function () {
    loginDropdown.classList.toggle('hidden');
  });
  loginBtn.addEventListener('mouseover', function () {
    loginDropdown.classList.remove('hidden');
  });

  // Close the dropdown if the user clicks outside of it
  window.addEventListener('click', function (e) {
    if (!loginBtn.contains(e.target) && !loginDropdown.contains(e.target)) {
      loginDropdown.classList.add('hidden');
    }
  });
});
document.addEventListener('DOMContentLoaded', function () {
  const loginBtn = document.getElementById('loginBtn');

  // Display a temporary message on hover (remove click functionality)
  loginBtn.addEventListener('mouseover', function () {
    alert("Visit our blog for more information!"); // Replace with desired message
  });
});

// Remove click event listener for login dropdown (if using this option)
loginBtn.removeEventListener('click', function () {});



        </script>
</body>
</html>
