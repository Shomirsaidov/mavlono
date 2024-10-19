<!DOCTYPE html>
<html>
<head>
    <title>Salom !</title>
    <style>
        .content {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .header {
            background-color: rgb(16, 95, 95);
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .body {
            padding: 20px;
        }
        .footer {
            background-color: rgb(16, 95, 95);
            padding: 20px;
            text-align: center;
            border-top: 1px solid #ddd;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="header">
            <h1>Руз ба хайр {{ $data['user']['name'] }} !</h1>
        </div>
        <div class="body">
            Шеъри наве аз яке аз шоирони дустодоштаи Шумо <strong style="color:indigo">{{ $data['poem']['poet']['name'] }}</strong> ба сомона ворид карда шуд !
            <p>{{ $data['poem']['content'] }},</p>
            <button class="bg-indigo-700 text-white">
                <a href="https://mavlono.tj">
                    хондани пурра...
                </a>
            </button>
        </div>
        <div class="footer">
            &copy; 2024 mavlono.tj All rights reserved.
        </div>
    </div>
</body>
</html>
