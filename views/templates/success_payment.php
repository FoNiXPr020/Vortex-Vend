<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Successful Payment</title>
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
        <h1 class="text-center text-white" style="color: #198754">Successful Payment</h1>
        <h3 class="text-center text-white"><?= $params['user']['username']; ?></h3>
        <p class="text-center text-white">Thank you for your payment, your product will be shipped within 48 hours, if you have any questions, please contact us</p>
        <div class="mt-1 text-center text-white">
            <table class="mt-3" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td style="color: #ffffff;">
                        &bull; Transaction ID : <b style="color: #0d6efd;"><?= $params['token']; ?></b> <br>
                        &bull; Payer ID : <b style="color: #0d6efd;"><?= $params['payer_id']; ?></b> <br>
                        &bull; Product : <b style="color: #0d6efd;"><?= $params['product']['product_name']; ?></b> <br>
                        &bull; Description : <b style="color: #0d6efd;"><?= $params['product']['description']; ?></b> <br>
                        &bull; Price : <b style="color: #0d6efd;">$<?= $params['product']['price']; ?></b> / Quantity : <b style="color: #0d6efd;"><?= $params['product']['quantity']; ?></b><br>
                    </td>
                </tr>
            </table>
        </div>
        <p class="mt-3 text-center text-white">Thank you,<br>VortexVend.com</p>
        <p class="text-center text-white">This email was sent from VortexVend.com. Please do not reply to this email.</p>
    </div>
</body>

</html>