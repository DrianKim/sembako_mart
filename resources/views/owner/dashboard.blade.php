@extends('owner.layouts.app')
@section('content')
    <div class="container">
        <h1>Owner Dashboard</h1>
        <p>Welcome, {{ Auth::user()->name }}!</p>
        <!-- Add more dashboard content here -->
    </div>
@endsection
