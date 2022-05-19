<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{Asset('css/app.css')}}">
    <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
    <title>Alterar Usuário</title>
</head>

<body>
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingThree" style="background-color: rgb(58, 58, 58);">
                        <h3 class="mb-0">
                            <a>
                                <strong style="color:azure;">Alterar Usuário</strong>
                            </a>
                        </h3>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('updateUsuario', $usuarios[0]->id) }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-header">
                            <div class="input-group mb-3">
                                <a href="{{route('cadastroUsuarios')}}" class="btn btn-warning" style="font-size:16px; margin-left:10px;background-color:rgb(255, 102, 0);color:cornsilk;font-family:arial">voltar</a>
                            </div>
                        </div>
                        <div style="margin-top:10px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-5 bg-white rounded">
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Nome:</label>
                                <input style="width:1000px;height: 40px;margin-top:15px;margin-left:20px" type="text" id="name" name="name" value="<?php echo $usuarios[0]->name; ?>"></input>
                            </div>
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">E-mail:</label>
                                <input style="width:1000px;height: 40px;margin-top:15px;margin-left:20px" type="text" id="email" name="email" value="<?php echo $usuarios[0]->email; ?>"></input>
                            </div>
                            <div class="input-group mb-3">
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;margin-left:60px">Função:</label>
                                <select style="width:1000px;height: 40px;margin-top:15px;margin-left:20px" value="" id="funcao" name="funcao">
                                  <option value="1" id="funcao" name="funcao">Usuário</option>
                                  <option value="0" id="funcao" name="funcao">Administrador</option>
                                </select>
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

</html>