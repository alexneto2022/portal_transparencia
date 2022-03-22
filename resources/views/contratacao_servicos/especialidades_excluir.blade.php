<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{Asset('css/app.css')}}">
    <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
    <title>Excluir especialidade</title>
</head>

<body>
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingThree" style="background-color: rgb(58, 58, 58);">
                        <h3 class="mb-0">
                            <a>
                                <strong style="color:azure;">Excluir especialidade médica</strong>
                            </a>
                        </h3>
                    </div>
                    <form method="POST" action="{{route('paginaEspecialidade')}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-header">
                            <div class="input-group mb-3">
                                <a href="{{route('paginaEspecialidade')}}" class="btn btn-warning" style="font-size:16px; margin-left:10px;background-color:rgb(255, 102, 0);color:cornsilk;font-family:arial">voltar</a>
                            </div>
                        </div>
                        <div style="margin-top:10px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-5 bg-white rounded">
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Nome:</label>
                                @foreach($Especialidades as $especialidade)
                                <input style="width:1000px;height: 40px;margin-top:15px;margin-left:20px;font-size:18px" type="textarea" id=nome name="nome" rows="4" cols="50" value="{{$especialidade->nome}}" disabled></input>
                                @endforeach
                            </div>
                            </form>
                            <div class="input-group mb-3">
                                <a href="{{route('excluirEspecialidade',$especialidade->id)}}" type="submit" class="btn btn-danger" style="font-size:15px; margin-top:10px" value="Excluir" id="Excluir" name="Excluir">Excluir</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    

</html>