<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{Asset('css/app.css')}}">
    <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
    <title>Alteração Contratação de serviços</title>
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
        //Verificando se pelo um checkbox especialidade foi marcado
    </script>
</head>

<body>
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingThree" style="background-color: rgb(58, 58, 58);">
                        <h3 class="mb-0">
                            <a>
                                <strong style="color:azure;">Alteração contratação de serviço</strong>
                            </a>
                        </h3>
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
                    @foreach($contratacao_servicos as $CS)
                    <form method="POST" action="{{route('alteraContratacao',$CS->id)}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-header">
                            <div class="input-group mb-3">
                                <a href="{{route('paginaContratacaoServicos')}}" class="btn btn-warning" style="font-size:16px; margin-left:10px;background-color:rgb(255, 102, 0);color:cornsilk;font-family:arial">voltar</a>
                            </div>
                        </div>
                        <div style="margin-top:10px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-5 bg-white rounded">
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Texto:</label>
                                <textarea style="width:1000px;height:60px;margin-top:15px;margin-left:20px" type="textarea" id=texto name="texto" rows="4" cols="50">{{$CS->texto}}</textarea>
                            </div>
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Com Prazo limite ?</label>
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:10px">Sim</label>
                                <?php $selected = ""; if($CS->tipoPrazo == 1){
                                     $selected = "checked";}?>
                                <input style="font-family:arial black;font-size:15px;margin-top:25px;margin-left:20px" type="checkbox" <?php echo $selected ?> id="tipoPrazo" name="tipoPrazo" value="1" onclick="desabilitarTipos('sim')" />
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Data prazo inicial:</label>
                                <input style=" height: 40px;margin-top:15px;margin-left:20px" type="date" id=prazoInicial name="prazoInicial" rows="4" cols="50" value="{{$CS->prazoInicial}}" ></input>
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:20px">Data prazo final:</label>
                                @if(old('tipo_mov1') == "on" || $CS->tipoPrazo == 1)
                                <input style=" height: 40px;margin-top:15px;margin-left:20px" type="date" id=prazoFinal name="prazoFinal" rows="4" cols="50" value="{{$CS->prazoFinal}}"></input>
                                @else
                                <input style=" height: 40px;margin-top:15px;margin-left:20px" type="date" id=prazoFinal name="prazoFinal" rows="4" cols="50" disabled ></input>
                                @endif  
                            </div>
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Unidade:</label>
                                <select style="width:500px; height: 40px;margin-top:15px;margin-left:20px" name="unidade_id" id="unidade_id">
                                    @foreach($Unidades as $unidade)
                                    <option value="{{$unidade->id}}"
                                    <?php if($unidade->id == $unidade_id){
                                        echo "selected";} 
                                    ?>>{{$unidade->name}}</option>
                                    @endforeach
                                </select>
                                    @if($CS->arquivo !== "")
                                    <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:10px">Arquivo:</label>
                                    <td>
                                        <a href="{{asset('storage/')}}/{{$CS->arquivo}}" target="_blank" title="<?php echo $CS->arquivo; ?>" class="list-group-item list-group-item-action" style="width:350px;height:70px; font-family:arial black; font-size:15px;margin-left:10px"><?php echo explode('/', (substr($CS->arquivo,0,80)))[1]; ?></a>
                                    </td>
                                    <td>
                                        <a type="submit" class="btn btn-danger btn-sm" href="{{route('exclArqContr',$CS->id)}}" style="margin-left:10px;;margin-top:20px;height:25px">X<i class="fas fa-times-circle"></i></a>
                                    </td>
                                    @else
                                    <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:10px">Arquivo:</label>
                                    <input style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:10px" type="file" id="nome_arq" name="nome_arq"></input>
                                    @endif
                            </div>
                            <div class="input-group mb-3">
                            <label style="font-family:Arial black, Helvetica, sans-serif;margin-left:10px;margin-bottom:30px;">Especialidades atualmente vinculadas a este contrato de serviço:</label>
                            <table class="table table-hover">
                                    <tr>
                                        <?php $i = 1; ?>
                                        <?php $m = 8; ?>
                                        @foreach($especialidades as $especialidade)
                                        @foreach($especialidade_contratacao as $Especialidade_contratacao)
                                        @if($especialidade->id == $Especialidade_contratacao->especialidades_id)
                                        <td>
                                            <label>&nbsp{{$especialidade->nome}}</label>
                                            <a href="{{route('exclEspeContr',[$CS->id,$especialidade->id])}}" class="btn btn-danger btn-sm">Excluir</a>
                                        @endif 
                                        @if($i == $m )
                                            <?php $m += 8; ?>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    <?php $i++; ?>
                                    @endforeach 
                                    </tr>    
                                </table>
                                <div>
                                <label style="font-family:Arial black, Helvetica, sans-serif;margin-left:10px;margin-bottom:30px;">
                                Escolha as novas especialidades:</label>
                                </div>
                                <table class="table table-hover">
                                    <tr>
                                        <input style="margin-left:20px;margin-top: 5px;" type="checkbox" onClick="toggle(this)" />
                                        <label style="font-family:Arial black, Helvetica, sans-serif;margin-left:10px;margin-bottom:30px;">Marcar/desmarcar todos</label>
                                        <?php $i = 1; ?>
                                        <?php $m = 8; ?>
                                        @foreach($especialidades as $especialidade)
                                        <td>
                                            <input type="checkbox" id="especialidade[]" class="especialidade" name="especialidade[]" value="<?php echo $especialidade->id; ?>">&nbsp{{$especialidade->nome}}</input>
                                            @if($i == $m)
                                            <?php $m += 8; ?>
                                        </td>
                                    </tr>
                                    @endif
                                    <?php $i++; ?>
                                    @endforeach
                                    </tr>
                                </table>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-info btn-sm" style="font-size:20px" value="Excluir" id="Salvar" name="Salvar">Alterar</button>
                                </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    
    @endforeach

</html>