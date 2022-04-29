@extends('navbar.default-navbar')

@section('content')

<head>
    <title>Excluir Contratação de serviços</title>
</head>

<body>

    <div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>

    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingThree" style="background-color: rgb(58, 58, 58);">
                        <h5 class="mb-0">
                            <a>
                                <strong style="color:azure;">Excluir contratação de serviço</strong>
                            </a>
                        </h5>
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
                    @foreach($contratacao_servicos as $CS)
                    <form method="POST" action="" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div style="margin-top:10px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-5 bg-white rounded">
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Texto:</label>
                                <textarea style="width:1000px;height: 40px;margin-top:15px;margin-left:20px" type="textarea" id=texto name="texto" rows="4" cols="50" disabled>{{$CS->texto}}</textarea>
                            </div>
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Data prazo inicial:</label>
                                <input style=" height: 40px;margin-top:15px;margin-left:20px" type="date" id=prazoInicial name="prazoInicial" rows="4" cols="50" value="{{$CS->prazoInicial}}" disabled></input>
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:20px">Data prazo final:</label>
                                <input style=" height: 40px;margin-top:15px;margin-left:20px" type="date" id=prazoFinal name="prazoFinal" rows="4" cols="50" value="{{$CS->prazoFinal}}" disabled></input>
                            </div>
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Unidade:</label>
                                <select style="width:500px; height: 40px;margin-top:15px;margin-left:20px" name="unidade_id" id="unidade_id" disabled>
                                    @foreach($Unidades as $unidade)
                                    <option value="{{$unidade->name}}">{{$unidade->sigla}}</option>
                                    @endforeach
                                </select>
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:10px">Arquivo:</label>
                                <input style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:10px" type="file" id="nome_arq" name="nome_arq" disabled></input>
                            </div>
                            <div class="input-group mb-3">
                                <div class="d-flex flex-wrap justify-content-between">
                                    @foreach($especialidades as $especialidade)
                                    <?php
                                    $marcado = '';
                                    if (in_array($especialidade->id, $especialidade_contratacao))
                                        $marcado = 'checked';
                                    ?>
                                    <div class="p-2">
                                        <input type="checkbox" id="especialidade[]" class="especialidade" name="especialidade[]" <?php echo $marcado; ?> value="<?php echo $especialidade->id; ?>" disabled>&nbsp{{$especialidade->nome}}</input>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="d-flex m-3 flex-wrap justify-content-between">
                                <div class="m-2">
                                    <a href="{{route('paginaContratacaoServicos',$id_und)}}" class="btn btn-warning" style="color:white; font-size: 16px;">voltar</a>
                                </div>
                                <div class="m-2">
                                    <a href="{{route('excluirContratacao',[$CS->id,$id_und])}}" class="btn btn-danger btn-sm" style="font-size:17px" value="Excluir" id="Salvar" name="Salvar">Excluir</a>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    @endforeach
    <script language="JavaScript">
        //Marcar ou desmarcar todas a especialidades
        function toggle(source) {
            checkboxes = document.getElementsByName('especialidade_');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
        //Verificando se pelo um checkbox especialidade foi marcado
    </script>
</body>

@endsection