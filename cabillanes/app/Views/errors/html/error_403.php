<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>403 - Access Forbidden</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }
        
        .container {
            max-width: 600px;
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            text-align: center;
        }
        
        .error-code {
            font-size: 100px;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        h1 {
            font-size: 32px;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        
        .message {
            font-size: 18px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        .info-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #e74c3c;
            margin-top: 30px;
            text-align: left;
        }
        
        .info-box strong {
            color: #e74c3c;
        }
        
        .contact {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #999;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">🚫</div>
        <div class="error-code">403</div>
        <h1>Access Forbidden</h1>
        <p class="message">
            <?= isset($message) ? esc($message) : 'Your IP address has been blocked from accessing this system.' ?>
        </p>
        
        <div class="info-box">
            <strong>Why am I seeing this?</strong>
            <p style="margin-top: 10px; color: #666;">
                Your IP address has been identified and blocked by the system administrator. 
                This may be due to security concerns or policy violations.
            </p>
        </div>
        
        <div class="contact">
            If you believe this is an error, please contact the system administrator.
        </div>
    </div>
</body>
</html>
