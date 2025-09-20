<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Recommendation Form</title>
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
    <h1 class="mb-4">Movie Recommendation Form</h1>
    <form action="{{ route('get-recommendations') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="movies">Select 5 Movies:</label>
            <select class="form-control" id="movies" name="movies[]" multiple required>
                @foreach($movies as $movie)
                    <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Get Recommendations</button>
    </form>
    <a href="{{ route('kmeans-control') }}" class="btn btn-secondary mt-3">KMeans Control</a>
</div>
</body>
</html>
