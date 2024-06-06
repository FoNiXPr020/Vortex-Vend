<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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
        <h1 class="text-center text-white">Contact from :</h1>
        <h3 class="text-center text-white"><?= $params['email']; ?></h3>
        <p class="text-center text-white"><?= $params['about']; ?></p>
        <div class="mt-3"></div>
        <div class="mt-3 text-center text-white" style="color: #027dff;">
            <p><?= $params['message']; ?></p>
        </div>
        <p class="mt-3 text-center text-white">Thank you,<br>VortexVend.net</p>
        <p class="mt-3 text-center text-white">This email was sent from VortexVend.net contact.</p>
    </div>
</body>

</html>