@section('title', 'Editar o Usuário {Auth::user()->name}')

@section('content')
    <h1>Editar o Usuário {{ Auth::user()->name }}</h1>

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sucesso!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <x-guest-layout>
            <x-auth-card>
                <x-slot name="logo">
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </a>
                </x-slot>

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="post" action=" {{ route('users.update', Auth::user()->id) }}">
                    @method('PUT')
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-label for="name" :value="__('Nome')" />
                        <input id="name" class="block mt-1 w-full" type="text" name="name"
                            value="{{ Auth::user()->name }}" required autofocus />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-label for="email" :value="__('Email')" />

                        <input id="email" class="block mt-1 w-full" type="email" name="email"
                            value="{{ Auth::user()->email }}" required autofocus />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('Senha')" />

                        <input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-label for="password_confirmation" :value="__('Confirmar senha')" />

                        <input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                            {{ __('Já poussi uma') }}
                        </a>

                        <button class="ml-4" type="submit">
                            {{ __('Criar conta') }}
                        </button>
                    </div>
                </form>
            </x-auth-card>
        </x-guest-layout>
