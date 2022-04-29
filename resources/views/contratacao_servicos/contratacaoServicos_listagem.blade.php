@extends('navbar.default-navbar')

@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>

<body>
    <div class="row" style="margin-top:15px;margin-left:5px;margin-right:5px">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingThree" style="background-color: rgb(58, 58, 58);">
                        <h5 class="mb-0">
                            <a>
                                <strong style="color:azure;">Contratações de serviços</strong>
                            </a>
                        </h5>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger" style="font-size:16px;">
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @elseif($sucesso =="ok")
                    <div class="alert alert-success" style="font-size:16px;">
                        <ul class="list-unstyled">
                            <li>{{ $validator }}</li>
                        </ul>
                    </div>
                    @endif
                    <div class="card-header">
                        <form method="POST" action="{{route('pesquisarContratacao',$id_und)}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="container">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="p-2 ">
                                        <a href="{{route('transparenciaContratacao',$id_und)}}" class="btn btn-warning" style="color:white;">Voltar</a>
                                    </div>
                                    <div class="p-2">
                                        <a href="{{route('novaContratacaoServicos',$id_und)}}" class="btn btn-success">Novo processo</a>
                                    </div>
                                    <div class="p-2">
                                        <a href="{{route('paginaEspecialidade',$id_und)}}" class="btn btn-success">Especialidades</a>
                                    </div>

                                    <div class="p-2" id="tipo" style='display:none;'>
                                        <select class="form-control" name="tipocontrato" id="tipocontrato">
                                            <option value="0">Selcione</option>
                                            <option value="1">Obras e reformas</option>
                                            <option value="2">Serviços</option>
                                            <option value="3">Aquisições</option>
                                        </select>
                                    </div>
                                    <div class="p-2" id="st" style='display:none;'>
                                        <select class="form-control" name="status" id="status">
                                            <option value="0">Selcione o status</option>
                                            <option value="1">Em breve</option>
                                            <option value="2">Divulgando</option>
                                            <option value="3">Prorrogado</option>
                                            <option value="4">Finalizado</option>
                                            <!--option value="5">Cancelado</option-->
                                        </select>
                                    </div>
                                    <div class="p-2" id="data" style='display:none;'>
                                        <label>Data Inicial:</label>
                                        <input type="date" name="dtini" id="dtini" class="form-control">
                                    </div>
                                    <div class="p-2" id="data2" style='display:none;'>
                                        <label>Data Final:</label>
                                        <input type="date" name="dtfim" id="dtfim" class="form-control">
                                    </div>
                                    <div class="p-2" id="nome" style='display:none;'>
                                        <input style="width:400px;" type="text" name="titulo" id="titulo" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                    <div class="p-2">
                                        <select class="form-control" id="filtro" name="filtro">
                                            <option value="selecione">Escolha o filtro</option>
                                            <option value="titulo">titulo</option>
                                            <option value="data">Data</option>
                                            <option value="tipo">Tipo</option>
                                            <option value="status">Status</option>
                                        </select>
                                    </div>
                                    <div class="p-2">
                                        <button type="submit" class="btn btn-primary" name="Pesquisar">Pesquisar</button>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap justify-content-center" style="overflow:auto">

                                </div>
                        </form>
                    </div>
                </div>
                <div class="d-flex card-header" style="overflow: auto;">
                    <table class="table table-sm">
                        <thead class="thead-dark" style="font-size: 15px;">
                            <tr>
                                <th>Status</th>
                                <th>Título</th>
                                <th>Tipo</th>
                                <th>Inicio</th>
                                <th>Fim</th>
                                <th>Prorrogação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody style="justify-content: center;">
                            @foreach($contratacao_servicos as $CS)
                            <tr>
                                <td style="width:20px;">
                                    <?php $hoje = date('Y-m-d'); ?>
                                    @if($CS->prazoInicial > $hoje && $CS->prazofinal > $hoje)
                                    <button type="button" class="btn btn-info"></button>
                                    @elseif($CS->prazoInicial <= $hoje && $CS->prazofinal >= $hoje)
                                        <button type="button" class="btn btn-success"></button>
                                        @elseif($CS->prazoInicial < $hoje && $CS->prazofinal < $hoje && $CS->prazoProrroga == "")
                                                <button type="button" class="btn btn-danger"></button>
                                                @elseif($CS->prazoProrroga >= $hoje)
                                                <button type="button" class="btn btn-warning"></button>
                                                @else
                                                <button type="button" class="btn btn-danger"></button>
                                                @endif
                                </td>
                                <td style="font-size:16px;width:300px;">
                                    <center>{{$CS->titulo}}</center>
                                </td>
                                <td style="font-size:16px;width:20px;" ?>
                                    <center>
                                        @if($CS->tipoContrata == 1)
                                        Obras e reformas
                                        @elseif($CS->tipoContrata == 2)
                                        Serviços
                                        @else
                                        Aquisições
                                        @endif
                                    </center>
                                </td>
                                <td style="font-size:16px;width:30px;">
                                    <?php echo date('d/m/Y', strtotime($CS->prazoInicial)); ?>
                                </td>
                                <td style="font-size:16px;width:30px;">
                                    @if($CS->prazofinal !== null)
                                    <?php echo date('d/m/Y', strtotime($CS->prazofinal)); ?>
                                    @endif
                                </td>
                                <td style="font-size:16px;width:30px;">
                                    @if($CS->prazoProrroga !== null)
                                    <?php echo date('d/m/Y', strtotime($CS->prazoProrroga)); ?>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap justify-content-center">
                                        <div class="p-1">
                                            <a class="btn btn-secondary" href="{{route('rp2',$CS->id)}}" target="_blank"><img class="link_thumb" src="{{route('rp2',$CS->id)}}" title=""><i class="bi bi-eye-fill"></i></a>
                                        </div>
                                        <div class="p-1">
                                            <a class="btn btn-info" href="{{route('pagProrrContr',[$CS->id,$id_und])}}"><i class="bi bi-calendar3"></i></a>
                                        </div>
                                        <div class="p-1">
                                            <a class="btn btn-dark" href="{{route('pagAlteraContratacao',[$CS->id,$id_und])}}"><i class="bi bi-pencil-square"></i></a>
                                        </div>
                                        <div class="p-1">
                                            <a class="btn btn-danger" href="{{route('pagExcluirContratacao',[$CS->id,$id_und])}}"><i class="bi bi-trash3"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#filtro').change(function() {
            var valor = $('#filtro').val();
            if (valor == "titulo") {
                $('#nome').show();
            } else {
                $('#nome').hide();
            }
            if (valor == "data") {
                $('#data').show();
                $('#data2').show();
            } else {
                $('#data').hide();
                $('#data2').hide();
            }
            if (valor == "tipo") {
                $('#tipo').show();
            } else {
                $('#tipo').hide();
            }
            if (valor == "status") {
                $('#st').show();
            } else {
                $('#st').hide();
            }
        });
    </script>
</body>
@endsection