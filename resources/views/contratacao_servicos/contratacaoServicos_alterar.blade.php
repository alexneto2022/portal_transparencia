@extends('navbar.default-navbar')
@section('content')

<body>
    <div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingThree" style="background-color: rgb(58, 58, 58);">
                        <h5 class="mb-0">
                            <a>
                                <strong style="color:azure;">Alterar contratação de serviço</strong>
                            </a>
                        </h5>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger" style="font-size:20px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
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
                    @foreach($contratacao_servicos as $CS)
                    <div class="container">
                        <form method="POST" action="{{route('alteraContratacao',array($CS->id,$id_und))}}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div style="margin-top:5px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-5 bg-white rounded">
                                <div class="d-flex flex-wrap justify-content-center">
                                    <div class="m-2">
                                        <label style="font-family:Arial black, Helvetica, sans-serif;">Título:</label>
                                    </div>
                                    <div class="m-2">
                                        <input class="form-control" style="width:400px;" type="text" name="titulo" id="titulo" value="{{$CS->titulo}}" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                    <div class="m-2">
                                        <label style="font-family:Arial black, Helvetica, sans-serif;">Tipo contratação:</label>
                                    </div>
                                    <div class="m-2">
                                        <select class="custom-select" style="width: 200px;" name="tipoContrata" id="tipoContrata">
                                            <option value="1" <?php if ($CS->tipoContrata == 1) {
                                                                    echo "selected";
                                                                } ?>>Obra e reforma</option>
                                            <option value="2" <?php if ($CS->tipoContrata == 2) {
                                                                    echo "selected";
                                                                } ?>>Serviço</option>
                                            <option value="3" <?php if ($CS->tipoContrata == 3) {
                                                                    echo "selected";
                                                                } ?>>Aquisição</option>
                                        </select>
                                        <input hidden name="unidade_id" id="unidade_id" value="{{$unidade_id}}" type="text" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mt-4">
                                        <label style="font-family:Arial black, Helvetica, sans-serif;font-size:15px;">Texto:</label>
                                        <textarea class="form-control" style=" height: 40px;" id=texto name="texto" aria-label="With textarea">{{$CS->texto}}</textarea>
                                        <p><label for="review"></label> <small class="caracteres"></small></p>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap justify-content-center" style="border-top:1px solid gray;">
                                    <div class="m-2">
                                        <label style="font-family:arial black;">Com Prazo limite ?</label>
                                        <label style="font-family:arial black;">Sim</label>
                                        <?php $selected = "";
                                        if ($CS->tipoPrazo == 1) {
                                            $selected = "checked";
                                        } ?>
                                        <input type="checkbox" <?php echo $selected ?> id="tipoPrazo" name="tipoPrazo" value="1" onclick="desabilitarTipos('sim')" />
                                    </div>
                                    <div class="m-2">
                                        <label style="font-family:Arial black, Helvetica, sans-serif;">Data prazo inicial:</label>
                                        <input type="date" id=prazoInicial name="prazoInicial" rows="4" cols="50" value="{{$CS->prazoInicial}}"></input>
                                    </div>
                                    <div class="m-2">
                                        <label style="font-family:Arial black, Helvetica, sans-serif;">Data prazo final:</label>
                                        <input type="date" id=prazoFinal name="prazoFinal" rows="4" cols="50" value="{{$CS->prazofinal}}" <?php if ($CS->tipoPrazo == 0) {
                                                                                                                                                echo "disabled";
                                                                                                                                            } ?>></input>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap justify-content-center">
                                    <div class="m-3">
                                        <label style="font-family:arial black;">Arquivo:</label>
                                    </div>
                                    @if($CS->arquivo !== "")
                                    <div class="m-3">
                                        <a href="{{asset('storage/')}}/{{$CS->arquivo}}" class="form-control" target="_blank" title="<?php echo $CS->arquivo; ?>" style="height:70px; font-family:arial black;"><?php echo explode('/', (substr($CS->arquivo, 0, 60)))[1]; ?></a>
                                    </div>
                                    <div class="m-3">
                                        <a type="submit" class="btn btn-danger" href="{{route('exclArqContr', array($CS->id,$id_und))}}"><i class="fas fa-times-circle m-2"></i></a>
                                    </div>
                                    @else
                                    <div class="m-3">
                                        <input class="form-control" style="font-family:arial black;" type="file" id="nome_arq" name="nome_arq"></input>
                                    </div>
                                    @endif
                                </div>
                                <div class="d-flex m-3 justify-content-center" style="border-top:1px solid gray;">
                                    <div class="m-3">
                                        <input s type="checkbox" onClick="toggle(this)" />
                                        <label style="font-family:Arial black, Helvetica, sans-serif;">Marcar/desmarcar todos</label>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap justify-content-between">
                                    @foreach($especialidades as $especialidade)
                                    <?php
                                    $marcado = '';
                                    if (in_array($especialidade->id, $especialidade_contratacao))
                                        $marcado = 'checked';
                                    ?>
                                    <div class="p-2">
                                        <input type="checkbox" id="especialidade[]" class="especialidade" name="especialidade[]" <?php echo $marcado; ?> value="<?php echo $especialidade->id; ?>">&nbsp{{$especialidade->nome}}</input>
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
        @endforeach
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