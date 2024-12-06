@extends('layouts.layout')

@section('title', 'Profile')

@section('content')

    <h1>Your Profile</h1>
    <table class="table">
    <tr>
        <th>Name:</th>
        <td>{{ auth()->user()->name }}</td>
    </tr>
    <tr>
        <th>Email:</th>
        <td>{{ auth()->user()->email }}</td>
    </tr>
    <tr>
        <th>Role:</th>
        <td>{{ ucfirst(auth()->user()->role) }}</td>
    </tr>
    <tr>
        <th>Registered at:</th>
        <td>{{ ucfirst(auth()->user()->created_at) }}</td>
    </tr>
    </table>
@endsection
