@extends('navbar.default-navbar')

@section('content')

<body>

    <div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>

    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingThree" style="background-color: rgb(58, 58, 58);display: flex;justify-content: center; text-align: center;">
                        <h5 class="mb-0">
                            <a>
                                <strong style="color:azure;">Prorrogação de contratação de serviço</strong>
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
                    <form method="POST" action="{{route('prorrContr',[$CS->id,$id_und])}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div style="margin-top:10px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-5 bg-white rounded">
                            <div class="input-group mb-3" style="display: flex;justify-content: center; text-align: center;">
                                <?php $disabled = "";
                                if ($CS->tipoPrazo == 0) {
                                    $disabled = "disabled";
                                } ?>
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;">Data prazo prorrogação:</label>
                                <input style=" height: 40px;margin-top:15px;margin-left:20px" type="date" id="prazoProrroga" name="prazoProrroga" rows="4" cols="50" value="{{$CS->prazoProrroga}}" <?php echo $disabled; ?>></input>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <h6><b>Erratas</b></h6>
                                            </th>
                                            <th>
                                                <h6><b>Data de upload</b></h6>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @if($CS->arquivo_errat !== "")
                                            <td>
                                                <center><a href="{{asset('storage/')}}/{{$CS->arquivo_errat}}" target="_blank" title="<?php echo $CS->arquivo_errat; ?>" class="list-group-item list-group-item-action" style="font-family:arial black; font-size:12px;"><?php echo explode('/', (substr($CS->arquivo_errat, 0, 80)))[1]; ?></a></center>
                                            </td>
                                            <td><label style="font-family:arial black;font-size:15px;"><?php echo  date('d/m/Y', strtotime($CS->dtup_errat)) ?></label></td>
                                            @else
                                            <td><input class="campo-dinamico" type="file" id="nome_arq_errat" name="nome_arq_errat" style="font-family:arial black;font-size:15px;" /></td>
                                            <td><label style="font-family:arial black;font-size:15px;"></label></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            @if($CS->arquivo_errat_2 !== "")
                                            <td>
                                                <center><a href="{{asset('storage/')}}/{{$CS->arquivo_errat_2}}" target="_blank" title="<?php echo $CS->arquivo_errat_2; ?>" class="list-group-item list-group-item-action" style="font-family:arial black; font-size:12px;"><?php echo explode('/', (substr($CS->arquivo_errat_2, 0, 80)))[1]; ?></a></center>
                                            </td>
                                            <td><label style="font-family:arial black;font-size:15px;"><?php echo  date('d/m/Y', strtotime($CS->dtup_errat_2)) ?></label></td>
                                            @else
                                            <td><input class="campo-dinamico" type="file" id="nome_arq_errat_2" name="nome_arq_errat_2" style="font-family:arial black;font-size:15px;" /></td>
                                            <td><label style="font-family:arial black;font-size:15px;"></label></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            @if($CS->arquivo_errat_3 !== "")
                                            <td>
                                                <center><a href="{{asset('storage/')}}/{{$CS->arquivo_errat_3}}" target="_blank" title="<?php echo $CS->arquivo_errat_3; ?>" class="list-group-item list-group-item-action" style="font-family:arial black; font-size:12px;"><?php echo explode('/', (substr($CS->arquivo_errat_3, 0, 80)))[1]; ?></a></center>
                                            </td>
                                            <td><label style="font-family:arial black;font-size:15px;"><?php echo  date('d/m/Y', strtotime($CS->dtup_errat_3)) ?></label></td>
                                            @else
                                            <td><input class="campo-dinamico" type="file" id="nome_arq_errat_3" name="nome_arq_errat_3" style="font-family:arial black;font-size:15px;" /></td>
                                            <td><label style="font-family:arial black;font-size:15px;"></label></td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--div class="input-group mb-4" style="display: flex;justify-content: center; text-align: center;">
                                <button type="button" onclick="AddTableRow()" class="btn btn-primary"><i style="font-size: 15px;" class="bi bi-plus-square"> Nova Errata</i></button>
                            </div-->
                            <div class="input-group mb-4" style="display: flex;justify-content: center; text-align: center;">
                                <a href="{{route('paginaContratacaoServicos',$id_und)}}" class="btn btn-warning" style="font-size:17px; margin-right:10px;font-family:arial"><i class="bi bi-arrow-counterclockwise">Voltar</i></a>
                                <button type="submit" class="btn btn-success btn-sm" style="font-size:15px" value="salvar" id="salvar" name="salvar"><i class="bi bi-check-lg"><b>Salvar<b></i></button>
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
            checkboxes = document.getElementsByClassName('especialidade');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>

</body>

@endsection