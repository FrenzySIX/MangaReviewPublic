@extends('layouts.app')

@section('content')
    <div class="container d-flex flex-wrap gap-2 justify-content-between
        bg-light border border-2 p-3 my-4">
        <form class="d-flex flex-wrap gap-1" method="get" action="{{ route('dashboard') }}">
            <input class="search-field form-control me-2" style="color:black" type="text" placeholder="Procurar"
                aria-label="Search" name="search">
            <button class="btn btn-outline search-submit" style="border-color: #FA4EAB; color: #FA4EAB"
                type="submit">Procurar</button>

        </form>

        <!-- Button trigger modal -->
        <div class="row">
            <div class="col">
                <button type="button" class="btn" style="background-color: #FA4EAB" data-bs-toggle="modal"
                    data-bs-target="#criarAnotacao">
                    Review
                </button>
            </div>
            <div class="col">
                <button type="button" class="btn" style="background-color: #FA4EAB" data-bs-toggle="modal"
                    data-bs-target="#criarImagem">
                    Imagem
                </button>
            </div>
        </div>

        <div class="modal fade" id="criarImagem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Postar Imagem</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div id="contact" class="container">

                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('image.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="file" class="form-control" name="image" />

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Criar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="criarAnotacao" tabindex="-1" aria-labelledby="criarAnotacaoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="criarAnotacaoLabel">Review</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('create.note') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <label>Título:</label>
                            <input class="form-control" type="text" name="title" required>
                            <label>Assunto:</label>
                            <textarea class="form-control" name="content" cols="50" rows="4" required></textarea>

                            <input class="form-control" type="hidden" value="#FFFFFF" name="color">

                            <input class="form-control" type="hidden" value="{{ Auth::user()->name }}" name="user">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">
                                Criar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

        {{ $notes->appends(['search' => request()->get('search')])->links('vendor.pagination.bootstrap-4') }}

        <div class="row flex-wrap justify-content-start g-2">

            @foreach (File::glob(public_path('images') . '/*') as $path)
                <div class="card border border-2 shadow p-3 col-12 col-md-6 col-lg-4 ">
                    <div class="d-flex justify-content-center">
                        <img width="200px" src="{{ str_replace(public_path(), '', $path) }}">
                    </div>
                </div>
            @endforeach

            @forelse($notes as $note)
                <div class="card border border-2 shadow p-3 col-12 col-md-6 col-lg-4"
                    style="background-color: {{ $note->color }}95;">
                    <div class="card-header" style="background-color: {{ $note->color }}45;">
                        <small style="color: lightsteelblue">Postado por {{ $note->user }}</small>

                    </div>
                    <div class="card-header" style="background-color: {{ $note->color }}45;">
                        {{ $note->title }}
                    </div>
                    <div class="card-body">
                        {{ $note->content }}
                    </div>
                    @if (Auth::user()->name == $note->user)
                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            {{-- Edição --}}
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#editar_anotacao" data-bs-note="{{ json_encode($note) }}">
                                Editar
                            </button>

                            {{-- Exclusão --}}
                            <form action="{{ route('delete.note', ['id' => $note->id]) }}" method="post">
                                @csrf
                                <button class="btn btn-danger" type="submit">Excluir</button>
                            </form>
                        </div>
                    @endif
                </div>



            @empty
                <div class="alert alert-danger">
                    Muito vazio por aqui...
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editar_anotacao" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('update.note') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <label>Título:</label>
                        <input class="form-control" type="text" name="title" id="title">
                        <label>Conteúdo:</label>
                        <textarea class="form-control" name="content" cols="30" rows="4" id="content"></textarea>
                        <label>Cor:</label>
                        <input class="form-control" type="color" name="color" id="color">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-success">
                            Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const exampleModal = document.getElementById('editar_anotacao')
        exampleModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget
            const recipient = button.getAttribute('data-bs-note')
            const note = JSON.parse(recipient);
            document.getElementById('id').value = note.id;
            document.getElementById('title').value = note.title;
            document.getElementById('content').value = note.content;
            document.getElementById('color').value = note.color;
        })
    </script>
@endsection
