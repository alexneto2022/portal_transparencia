@extends('navbar.default-navbar')

@section('content')

<head>
    <title>Nova especialidade</title>
</head>

<body>
    <div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingThree" style="background-color: rgb(58, 58, 58);">
                        <h3 class="mb-0">
                            <a>
                                <strong style="color:azure;">Nova especialidade médica</strong>
                            </a>
                        </h3>
                    </div>
                    @if ($sucesso == "ok")
                    <div class="alert alert-success" style="font-size:20px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @elseif($sucesso == "no")
                    <div class="alert alert-danger" style="font-size:20px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST" action="{{route('salvarEspecialidade',$id_und)}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-header">
                            <div class="input-group mb-3">
                                <a href="{{route('paginaEspecialidade',$id_und)}}" class="btn btn-warning" style="font-size:16px; margin-left:10px;color:white;font-family:arial">voltar</a>
                            </div>
                        </div>
                        <div style="margin-top:10px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-5 bg-white rounded">
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Nome:</label>
                                <input style="width:1000px;height: 40px;margin-top:15px;margin-left:20px" type="textarea" id=nome name="nome" rows="4" cols="50"></input>
                            </div>
                            <div class="input-group mb-3">
                                <input type="submit" class="btn btn-success btn-sm" style="font-size:20px; margin-top:10px" value="Salvar" id="Salvar" name="Salvar" />
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    </form>

</body>

@endsection