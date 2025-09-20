
@extends('layouts.app')

    <title>Apriori Algorithm Settings</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">




@section('content')

<div class="container mt-5">
    <h2>Apriori Algorithm Settings</h2>
    
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    
    @if(session()->has('Add'))
        <div class="d-flex justify-content-center alert alert-success alert-dismissible fade show" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{ session()->get('Add') }}</strong>
            
        </div>
@endif

    <form action="/store-parameters" method="POST">
        @csrf
        <div class="form-group">
            <label for="min_support">Minimum Support:</label>
            <input type="number"  step="0.001" min="0" max="1" name="min_support" id="min_support" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="min_confidence">Minimum Confidence:</label>
            <input type="number" step="0.001" min="0" max="1" name="min_confidence" id="min_confidence" class="form-control" required>
        </div>
        
            <input type="submit" value="Store Parameters">
        </form>
        
    
</div>
@endsection
