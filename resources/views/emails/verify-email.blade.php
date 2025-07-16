<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eeeeee;
        }
        .content {
            padding: 20px 0;
            line-height: 1.6;
        }
        .button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 15px;
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888888;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div>
            Movie quotes
        </div>

        <div class="header">
            <h1>Hola {{ $username }}</h1>
        </div>
        <div class="content">
            <p>Thanks for joining Movie quotes! We really appreciate it. Please click the button below to verify your account:</p>
            <a href="{{ $url }}" class="button">Verify account</a>
            <p>If clicking doesn't work, you can try copying and pasting it to your browser:</p>
            <a href="{{ $url }}">{{ $url }}</a>
            <p>If you have any problems, please contact us: support@moviequotes.ge</p>
        </div>
        <div class="footer">
            <p>MovieQuotes Crew</p>
        </div>
    </div>
</body>
</html>
