@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Recommended Movies by Apriori</h1>
        <br>

        @if (empty($recommendedMovies))
            <p>No recommendations found based on the movies you entered.</p>
        @else
            <ul >
                @foreach ($recommendedMovies as $movie)
                    <li style="font-weight: bold">{{ $movie['title']   }}    <span style="margin-left:20px"> |   <span style="margin-left:20px"> {{ $movie['listed_in']   }}</span></span></li>
                    <br>
                @endforeach
            </ul>
        @endif

    </div>
@endsection
