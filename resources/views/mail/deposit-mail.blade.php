<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #5e1bb9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        p {
            color: #fff;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            /* Button color remains the same */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #999;
        }
    </style>

</head>

<body>

    <div class="container">
        <h1 style="color: white">Deposit Notification</h1>
        <p>Hello {{ App\Models\User::find($userId)->name }} ,</p>
        <p>We are writing to inform you that a deposit of {{ $amount }} {{ config('app.currency') }} has been
            successfully processed to your
            account.</p>
        <p>If you have any questions or concerns regarding this deposit, please feel free to contact our customer
            support.</p>
        <p>Thank you for choosing our services!</p>
        {{-- <p>
            <a href="[Your Website URL]" class="button">Visit Our Dashboard</a>
        </p> --}}
        <p class="footer">Best regards,<br> {{ config('app.name') }} </p>
    </div>

</body>

</html>
