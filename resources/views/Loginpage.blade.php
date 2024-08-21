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
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .navbar {
            width: 100%;
            background-color: #333;
            overflow: auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: background 0.3s;
            padding: 8px 16px;
        }

        .navbar a:hover {
            background-color: #555;
        }

        .navbar .active {
            background-color: #ff6347;
        }

        .navbar .search-container {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .navbar input[type="text"] {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            margin-left: 8px;
            font-size: 16px;
            outline: none;
        }

        .navbar input[type="text"]:focus {
            border-color: #ff6347;
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
            background: white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            font-size: 32px;
            color: #ff6347;
            margin-bottom: 30px;
            font-weight: 700;
            text-align: center;
            position: relative;
        }

        h2::after {
            content: '';
            width: 60px;
            height: 4px;
            background: #ff6347;
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
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            text-align: center;
        }

        .border:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        h3 {
            font-size: 24px;
            margin-bottom: 16px;
            font-weight: 600;
            color: #ff6347;
        }

        p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
        }

        .login-container {
            max-width: 400px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #ff6347;
            text-align: center;
        }

        .login-container input[type="text"], 
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #ff6347;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-container button:hover {
            background-color: #e5533a;
        }

        .login-container .error {
            color: red;
            font-size: 14px;
            display: none;
            margin-bottom: 15px;
            text-align: center;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 30px;
            font-size: 16px;
            margin-top: 50px;
            border-top: 4px solid #ff6347;
        }

        footer a {
            color: #ff6347;
            text-decoration: none;
            font-weight: 500;
            transition: text-decoration 0.3s;
        }

        footer a:hover {
            text-decoration: underline;
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
        </div>
    </div>

    <!-- Login Form -->
    <div class="login-container">
        <h2>Login</h2>
        <div class="error" id="error-message">Invalid username or password.</div>
        <input type="text" id="username" placeholder="Username">
        <input type="password" id="password" placeholder="Password">
        <button onclick="login()">Login</button>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Clothing Store. All rights reserved.</p>
        <p><a href="#">Contact Us</a></p>
    </footer>

    <script>
        // Login function
        function login() {
            // Get input values
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            // Basic validation
            if (username === '' || password === '') {
                showErrorMessage('Please fill in both fields.');
                return;
            }

            // Simulated user authentication (example only)
            const hardcodedUsername = 'admin';
            const hardcodedPassword = 'password123';

            if (username === hardcodedUsername && password === hardcodedPassword) {
                alert('Login successful!');
                // Redirect to dashboard or another page
                window.location.href = 'dashboard.html';
            } else {
                showErrorMessage('Invalid username or password.');
            }
        }

        // Function to show an error message
        function showErrorMessage(message) {
            const errorMessage = document.getElementById('error-message');
            errorMessage.textContent = message;
            errorMessage.style.display = 'block';
        }
    </script>
</body>
</html>
