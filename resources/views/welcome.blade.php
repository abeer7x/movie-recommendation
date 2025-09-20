<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Movie Recommendation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .btn {
            width: 100%;
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Project Movie Recommendation</h1>
    <a href="{{ route('recommendation-form') }}" class="btn btn-primary">استخدام خوارزمية KMeans</a>
    <a href="{{ route('parameters') }}" class="btn btn-secondary">استخدام خوارزمية Apriori</a>
</div>
</body>
</html>
