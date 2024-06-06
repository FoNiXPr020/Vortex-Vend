<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1e1e1e;
            color: #ffffff;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #292929;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .verification-code {
            padding: 10px;
            background-color: #333333;
            border-radius: 5px;
            text-align: center;
            font-size: 20px;
            color: #ffffff;
            letter-spacing: 8px;
        }

        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #017eab;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 150px;
            height: auto;
        }

        .text-center {
            text-align: center;
        }

        .text-white {
            color: #ffffff;
        }

        .mt-3 {
            margin-top: 30px
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="https://i.imgur.com/aCoPj1U.png" width="150" height="auto" alt="VortexVend">
        </div>
        <h1 class="text-center text-white">Email Verification</h1>
        <p class="text-center text-white">Thank you for signing up. Please use the following verification code to complete your email verification:</p>
        <div class="verification-code mt-3"><?= $params['verification_code'] ?></div>
        <div class="mt-3 text-center text-white">
            <p>If you didn't request this verification, Please ignore this email.</p>
            <a href="<?= $uri ?>/verification" class="cta-button text-center">Verify Now</a>
        </div>
        <p class="mt-3 text-center text-white">Thank you,<br>VortexVend.com</p>
        <p class="mt-3 text-center text-white">This email was sent from VortexVend.com. Please do not reply to this email.</p>
    </div>
</body>

</html>