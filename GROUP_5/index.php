<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div class="login-container">
        <form class="login-form" id="loginForm">
            <h2>Welcome Back</h2>
            <p>Please enter your details</p>
            
            <div id="message" class="message"></div>
            
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="login-btn" id="loginBtn">Login</button>
            
            <div class="form-footer">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </form>
    </div>
    
    <script src="JS/script.js"></script>
</body>
</html>
