<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KMeans Control</title>
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
    <h1>KMeans Control</h1>
    <form action="{{ route('apply-kmeans') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="k">Select K:</label>
            <input type="number" class="form-control" id="k" name="k" value="5" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary">Apply KMeans</button>
    </form>
    <a href="{{ route('recommendation-form') }}" class="btn btn-secondary mt-3">Back</a>
</div>
</body>
</html>
