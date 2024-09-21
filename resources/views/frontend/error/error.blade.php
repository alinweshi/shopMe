<!-- resources/views/errors/404.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>404 Not Found</h1>
    <p>The page you are looking for does not exist.</p>
    <a href="{{ route('shop.index') }}" class="btn btn-primary">Go Back to Home</a>
</div>
@endsection