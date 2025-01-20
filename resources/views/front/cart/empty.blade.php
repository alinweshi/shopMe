@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Cart is Empty</h2>
    <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
</div>
@endsection