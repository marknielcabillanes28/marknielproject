<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-card {
            background-color: #ffffffcc;
            padding: 40px 30px;
            border-radius: 15px;
            width: 400px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .register-card h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .register-card label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .register-card input[type="text"],
        .register-card input[type="password"],
        .register-card select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 15px;
        }

        .register-card button {
            width: 100%;
            padding: 14px;
            background-color: #5563DE;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .register-card button:hover {
            background-color: #3b46b0;
        }

        .register-card .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .register-card .login-link a {
            color: #5563DE;
            text-decoration: none;
        }

        .register-card .login-link a:hover {
            text-decoration: underline;
        }

        .message {
            text-align: center;
            margin-bottom: 20px;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <h1>Register</h1>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="message"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('/auth/store') ?>">
            <label>Username:</label>
            <input type="text" name="username" placeholder="Enter username" required>

            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter password" required>

            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" placeholder="Confirm password" required>

            <!-- ✅ Role selector added -->
            <label>Role:</label>
            <select name="role" required>
                <option value="user" selected>User</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">Register</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="<?= base_url('/auth/login') ?>">Login here</a>
        </div>
    </div>
</body>
</html>
