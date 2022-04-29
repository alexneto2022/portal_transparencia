@extends('navbar.default-navbar')
@section('content')


<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>

<body>
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingThree" style="background-color: rgb(58, 58, 58);">
                        <h5 class="mb-0">
                            <a>
                                <strong style="color:azure;">Nova contratação de serviço</strong>
                            </a>
                        </h5>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger" style="font-size:20px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @elseif($sucesso =="ok")
                    <div class="alert alert-success" style="font-size:20px;">
                        <ul>
                            <li>{{ $validator }}</li>
                        </ul>
                    </div>
                    @endif
                    <div class="container">
                        <form method="POST" action="{{route('salvarContratacaoServicos',$id_und)}}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div style="margin-top:5px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-5 bg-white rounded">
                                <div class="d-flex flex-wrap justify-content-center">
                                    <div class="m-2">
                                        <label style="font-family:Arial black, Helvetica, sans-serif;">Título:</label>
                                    </div>
                                    <div class="m-2">
                                        <input class="form-control" style="width:300px;" type="text" name="titulo" id="titulo" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                    <div class="m-2">
                                        <label style="font-family:Arial black, Helvetica, sans-serif;">Tipo de Contratação:</label>
                                    </div>
                                    <div class="m-2">
                                        <select class="custom-select" style="width: 200px;" name="tipoContrata" id="tipoContrata">
                                            <option value="1">Obra e reforma</option>
                                            <option value="2">Serviço</option>
                                            <option value="3">Aquisição</option>
                                        </select>
                                        <input hidden style="margin-left:20px;margin-top: 5px;" name="unidade_id" id="unidade_id" value="{{$id_und}}" type="text" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 20px;">
                                        <label style="font-family:Arial black, Helvetica, sans-serif;font-size:15px;">Texto:</label>
                                        <textarea class="form-control" style=" height: 50px;" id=texto name="texto" aria-label="With textarea"></textarea>
                                        <p><label for="review"></label> <small class="caracteres"></small></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4" style="margin-top: 20px;">
                                        <label style="font-family:Arial black, Helvetica, sans-serif;">Com Prazo limite ?</label>
                                        <label>Sim</label>
                                        <input class="form-control" type="checkbox" id="tipoPrazo" name="tipoPrazo" value="1" onclick="desabilitarTipos('sim')" />
                                    </div>
                                    <div class="col-md-4" style="margin-top: 20px;">
                                        <label style="font-family:Arial black, Helvetica, sans-serif;">Data prazo inicial:</label>
                                        <input type="date" id=prazoInicial name="prazoInicial" rows="4" cols="50"></input>
                                    </div>
                                    <div class="col-md-4" style="margin-top: 20px;">
                                        <label style="font-family:Arial black, Helvetica, sans-serif;">Data prazo final:</label>
                                        @if(old('tipo_mov1') == "on")
                                        <input type="date" id=prazoFinal name="prazoFinal" rows="4" cols="50"></input>
                                        @else
                                        <input type="date" id=prazoFinal name="prazoFinal" rows="4" cols="50" disabled></input>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 20px;">
                                        <label style="font-family:Arial black, Helvetica, sans-serif;">Arquivo:</label>
                                        <input class="form-control" type="file" id="nome_arq" name="nome_arq"></input>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 20px;">
                                        <label style="font-family:Arial black, Helvetica, sans-serif;">Especialidades:</label>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap justify-content-between">
                                    @foreach($especialidades as $especialidade)
                                    <div class="p-2">
                                        <input type="checkbox" id="especialidade[]" class="especialidade" name="especialidade[]" value="<?php echo $especialidade->id; ?>">&nbsp{{$especialidade->nome}}</input>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-md-6" style="margin-top: 20px;">
                                        <a href="{{route('paginaContratacaoServicos',$id_und)}}" class="btn btn-warning" style="color:white; font-size: 18px;">voltar</a>
                                    </div>
                                    <div class="col-md-6" style="margin-top: 20px;">
                                        <input type="submit" value="Salvar" id="Salvar" name="Salvar" class="btn btn-success btn-sm" style="font-size:18px" />
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    <script language="JavaScript">
        //Marcar ou desmarcar todas a especialidades
        function toggle(source) {
            checkboxes = document.getElementsByClassName('especialidade');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }

        function desabilitarTipos(valor) {
            var a = document.getElementById('tipoPrazo').checked;

            if (a == true) {
                document.getElementById('prazoFinal').disabled = false;
            } else {
                document.getElementById('prazoFinal').disabled = true;
            }
        }
        //Contador de caracteres
        $(document).on("input", "#texto", function() {
            var limite = 255;
            var informativo = "caracteres restantes.";
            var caracteresDigitados = $(this).val().length;
            var caracteresRestantes = limite - caracteresDigitados;

            if (caracteresRestantes <= 0) {
                var comentario = $("textarea[name=texto]").val();
                $("textarea[name=texto]").val(comentario.substr(0, limite));
                $(".caracteres").text("0 " + informativo);
            } else if (caracteresRestantes >= 16) {
                $(".caracteres").css("color", "#000000");
                $(".caracteres").text(caracteresRestantes + " " + informativo);
            } else if (caracteresRestantes >= 0 && caracteresRestantes <= 15) {
                $(".caracteres").css("color", "red");
                $(".caracteres").text(caracteresRestantes + " " + informativo);
            } else {
                $(".caracteres").text(caracteresRestantes + " " + informativo);
            }
        });
    </script>
</body>
@endsection