

@extends('layouts.app')

@section('content')
<h1>Recommended Movies by Apriori</h1>
        <br>
<div class="container">
    <form action="{{route('recommendbyGenreByName')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="genre">Enter Movie Name:</label>
            <input type="text" id="genre" name="genre" class="form-control" required>
            
        </div>
        <button type="submit" class="btn btn-primary">Get Recommendations</button>
    </form>
</div>
@endsection
