<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>We'll be back soon!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Modern Font -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Orbitron', sans-serif;
            background: linear-gradient(135deg, #121212, #1c1c1c);
            color: #00d4d4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            text-align: center;
            max-width: 700px;
            padding: 20px;
            animation: fadeIn 1.2s ease-in-out;
        }

        h1 {
            font-size: 3.2rem;
            color: #00d4d4;
            text-shadow: 0 0 5px rgba(0, 212, 212, 0.4);
            margin-bottom: 20px;
        }

        p {
            font-size: 1.1rem;
            color: #b0b0b0;
            margin-bottom: 30px;
        }

        .spinner {
            width: 55px;
            height: 55px;
            border: 5px solid #333;
            border-top: 5px solid #00d4d4;
            border-radius: 50%;
            margin: 30px auto;
            animation: spin 1s linear infinite;
            box-shadow: 0 0 8px rgba(0, 212, 212, 0.3);
        }

        .footer {
            color: #777;
            font-size: 0.9rem;
            margin-top: 40px;
            letter-spacing: 0.5px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛠️ Under Maintenance</h1>
        <p>We're upgrading our system to serve you better.<br>Please check back shortly.</p>
        <div class="spinner"></div>
        <p class="footer">— Developer Team 🚀</p>
    </div>
</body>
</html>
