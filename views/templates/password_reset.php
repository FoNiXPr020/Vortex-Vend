<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery</title>
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

        .mt-2 {
            margin-top: 20px
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="https://i.imgur.com/aCoPj1U.png" width="150" height="auto" alt="VortexVend">
        </div>
        <h1 class="text-center text-white">Password Recovery</h1>
        <p class="text-center text-white">If you're having trouble remembering your password, no worries! Please click the button below to recover your password:</p>
        <div class="mt-1 text-center text-white">
            <a href="<?= $uri ?>/reset-password/<?= $params['token'] ?>" class="cta-button text-center text-white mt-2">Reset Password</a>
        </div>
			<div class="mt-3 text-center text-white">
			<p>If you didn\'t request this password, Please ignore this email.</p>
			</div>
        <p class="mt-3 text-center text-white">Thank you,<br>VortexVend.com</p>
        <p class="mt-3 text-center text-white">This email was sent from VortexVend.com. Please do not reply to this email.</p>
    </div>
</body>

</html>