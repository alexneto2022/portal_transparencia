<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{Asset('css/app.css')}}">
    <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <title>Cadastro de Usuários</title>
</head>

<body>
    <div class="row" style="margin-top:15px;margin-left:5px;margin-right:5px">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingThree" style="background-color: rgb(58, 58, 58);">
                        <h3 class="mb-0">
                            <a>
                                <strong style="color:azure;">Cadastro de Usuários</strong>
                            </a>
                        </h3>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-success">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-header">
                        <form method="POST" action="{{route('pesquisarUsuario')}}" >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="input-group mb-3">
                                <select style="margin-top:10px;font-family:arial;" class="form-control" id="pesq" name="pesq">
                                    <option value="0" id="pesq" name="pesq">Nome</option>
                                    <option value="1" id="pesq" name="pesq">E-mail</option>
                                </select>
                                <input style="margin-top: 8px;font-size:18px; margin-left:10px;float:left; font-family:arial;height:40px;" class="form-control" type="text" id="pesq2" name="pesq2"></input>
                                <button type="submit" style="margin-top: 8px;font-size:18px; margin-left:10px;float:left; font-family:arial;height:40px;" class="btn btn-primary" name="Pesquisar">Pesquisar</button>
                        </form>
                        <a href="{{route('cadastroNovoUsuario')}}" class="btn btn-success" style="margin-top: 8px;height:40px;font-size:16px; margin-left:10px; font-family:arial">Novo Usuário</a>
                        <a href="{{route('home')}}" class="btn btn-warning" style="margin-top: 8px;height:40px;font-size:16px; margin-left:10px;background-color:rgb(255, 102, 0);color:cornsilk;font-family:arial">voltar</a>
                    </div>
                </div>
                <table>
                    <div class="card-header">
                        <table class="table table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Alterar</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usuarios as $user)
                                <tr>
                                    <th class="text-truncate" style="font-size:16px;max-width:150px;" title="<?php echo $user->texto; ?>">{{$user->name}}</th>
                                    <th class="text-truncate" style="font-size:16px;max-width:80px;" title="<?php echo $user->email; ?>">{{$user->email}}</th>
                                    <th style="font-size:18px;max-width:5px;"><a href="{{route('cadastroAlterarUsuario',$user->id)}}"><center><button class="btn btn-dark"><i class="bi bi-pencil-square"></i></button></center></a></th>
                                    <th style="font-size:18px;max-width:5px;"><a href="{{route('cadastroExcluirUsuario',$user->id)}}"><center><button class="btn btn-danger"><i class="bi bi-trash3"></i></button><center></a></th>
                                </tr>                                                   
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </table>
            </div>
        </div>
    </div>
</body>

</html>