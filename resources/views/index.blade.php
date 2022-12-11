@extends('layouts.app')

@section('content')
    <h1>Lista de usuarios</h1>

    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><button><a href="{{ route('users.show', $user->id) }}">Detalhes</a></button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection('content')
