<link rel="stylesheet" type="text/css" href="{{ url('/css/nav.css') }}" />


<nav class="navbar navbar-expand-lg">
    <div class="container-fluid row d-flex justify-content-center">
        <div class="col-md-8">
            <a class="navbar-brand" href="{{ route('welcome') }}">Manga Review</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sobre nós</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Mangás
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Categorias</a></li>
                            <li><a class="dropdown-item" href="#">Recomendações</a></li>
                            <li><a class="dropdown-item" href="#">Todos</a></li>
                        </ul>
                    </li>
                </ul>

                @if (Route::current()->getName() == 'welcome')
                    <form class="d-flex" class="search-form" method="get" action="{{ route('welcome') }}">
                        <input class="search-field form-control me-2" type="search" placeholder="Procurar"
                            aria-label="Search" value="" name="search">
                        <button class="btn btn-outline-success search-submit" type="submit"
                            style="border-color: #FA4EAB; color: #FA4EAB">Procurar</button>
                    </form>
                @endif

                <div class="dropdown d-flex justify-content-end col-2">
                    @if (Route::has('login'))
                        @auth
                            <a class="dropdown-toggle btn btn-outline-secondary rounded" style="border-color: #FA4EAB"
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end col-2" aria-labelledby="navbarDropdown">
                                <li>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Sair</button>
                                    </form>
                                    <a href="{{ url('/dashboard') }}" class="dropdown-item"
                                        style="text-decoration: none; color: black">Dashboard</a>
                                </li>
                                <li>
                                    <a href="{{ route('users.edit', Auth::user()->id) }}" class="dropdown-item"
                                        style="text-decoration: none; color: black">Editar</a>
                                </li>
                                <li>
                                    @if (Route::current()->getName() == 'dashboard')
                                        <a href="{{ route('users.index') }}" class="dropdown-item"
                                            style="text-decoration: none; color: black">Listar usuários</a>
                                    @endif
                                </li>
                            </ul>
                        @else
                            <a href="{{ route('login') }}" class="dropdown-item"
                                style="text-decoration: none; color: bla">Log-in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 dropdown-item"
                                    style="text-decoration: none; color: blac">Criar conta</a>
                            @endif
                        @endauth
                    @endif
                </div>

            </div>

        </div>
    </div>
</nav>

{{-- @if (Route::has('login'))
    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        @auth
            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
            @endif
        @endauth
    </div>
@endif --}}
