@extends('layouts.admin')

@section('content')
    <h1>Liste des utilisateurs</h1>
    <ul>
        @foreach($users as $user)
            <li>{{ $user->name }} - {{ $user->email }} - {{ $user->role }}</li>
        @endforeach
    </ul>
@endsection
