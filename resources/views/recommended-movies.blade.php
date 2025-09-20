<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommended Movies</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1>Recommended Movies</h1>
    <ul class="list-group">
        @foreach($recommendedMovies as $movie)
            <li class="list-group-item">{{ $movie->title }}</li>
        @endforeach
    </ul>
    <a href="{{ route('recommendation-form') }}" class="btn btn-primary mt-3">Back</a>
</div>
</body>
</html>
