
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Clothing Store</title>
    
</head>
<style>
   
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f0f0f0;
    color: #444;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
}

.login-box {
    background-color: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 28px;
    color: #333;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    color: #555;
}

.form-group input {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 16px;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: border-color 0.3s ease;
}

.form-group input:focus {
    border-color: #ff6347;
    outline: none;
}

button[type="submit"] {
    width: 100%;
    padding: 14px;
    border-radius: 8px;
    border: none;
    background-color: #ff6347;
    color: white;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #ff4500;
}

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
}

.form-options a {
    font-size: 14px;
    color: #ff6347;
    text-decoration: none;
}

.form-options a:hover {
    text-decoration: underline;
}

</style>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Sign In</h2>
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="form-group">
                    <button type="submit">Sign In</button>
                </div>
                <div class="form-options">
                    <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                    <a href="{{ route('register') }}" class="create-account">Create an Account</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
