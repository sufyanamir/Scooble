<!DOCTYPE html>
<html>
<head>
    <title>Subscription Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        /* .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
        } */
        h3 {
            color: #333333;
            margin-bottom: 20px;
        }
        h2 {
            color: #555555;
            margin-bottom: 20px;
        }
        .message {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
        }
        .logo img {
            display: block;
            margin: 0;
            /* max-width: 200px; */
            /* height: auto; */
        }
        /* @media (max-width: 1100px){
            .logo{
                margin-left: 39% !important;
            }
        } */
    </style>
</head>
<body style="background-color: #f9f9f9;">
    <div class="container" style="text-align: center;">
        <div class="logo" align="center">
            <img src="{{ $message->embed(public_path('assets/images/Group5.png')) }}" alt="logo" />
        </div>
        <h3>Dear, {{ $emailData['name'] }}</h3>
        <div class="message">
            <h3>{{ $emailData['body'] }}</h3>
            <p>You have subscribed to the package: <strong>{{ $emailData['package_name'] }}</strong>.</p>
        </div>
        <div class="footer">
        <h3>Thank you for choosing our services!</h3>
        </div>
    </div>
</body>
</html>
