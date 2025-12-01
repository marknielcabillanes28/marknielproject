<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        /* Body and background */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Card container */
        .login-card {
            background: rgba(255,255,255,0.95);
            padding: 40px 30px;
            border-radius: 15px;
            width: 350px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        /* Heading */
        .login-card h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 26px;
            color: #333;
        }

        /* Labels */
        .login-card label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        /* Inputs */
        .login-card input[type="text"],
        .login-card input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 14px;
        }

        /* Button */
        .login-card button {
            width: 100%;
            padding: 14px;
            background-color: #764ba2;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-card button:hover {
            background-color: #5a3591;
        }

        /* Flash message */
        .flash-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        /* Register link */
        .login-card .register-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #764ba2;
            text-decoration: none;
        }

        .login-card .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>Login</h1>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="flash-message"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('/auth/auth') ?>">
            <label>Username:</label>
            <input type="text" name="username" placeholder="Enter your username" required>

            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
        </form>

        <a class="register-link" href="<?= base_url('/auth/register') ?>">Don't have an account? Register</a>
    </div>
</body>
</html>
