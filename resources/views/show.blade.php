@extends('layouts.app')

@section('content')
    <h1>Listagem do usuário {{ $user->name }}</h1>

    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Data de criação</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                </tr>
        </tbody>
    </table>
@endsection('content')
