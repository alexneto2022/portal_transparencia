<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        

        <title>Portal da Transparencia - HCP</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- BOOTSTRAP -->
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">

        <!-- OWN STYLE -->
        <link rel="stylesheet" href="{{asset('css/style.css')}}">

        <!-- Font Awesome KIT -->
        <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>

        <style>

.navbar .dropdown-menu .form-control {
    width: 300px;
}
        </style>

    </head>
    <body>
    <!-- As a heading -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm p-3 mb-5 rounded fixed-top">
        <a class="navbar-brand" href="#">
            <img src="{{asset('img/Imagem1.png')}}"  height="50" class="d-inline-block align-top" alt="">
            <span class="navbar-brand mb-0 h1" style="margin-left:10px;margin-top:5px ;color: rgb(103, 101, 103) !important">
                <h4 class="d-none d-sm-block">PORTAL DA TRANSPARÊNCIA</h4>
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item" style="margin-right: 5px;">
                        <a href="#unidades" class="btn btn-success btn-lg" href="#">Unidades</a>
                    </li>
                    <li class="nav-item" style="margin-right: 5px;">
                        <a href="#sobre" class="btn btn-secondary btn-lg" href="#">Sobre</a>
                    </li>
			        <li class="dropdown order-1">
                        <button type="button" id="dropdownMenu1" data-toggle="dropdown" class="btn btn-outline-danger btn-lg">Acesso restrito<span class="caret"><i class="fas fa-lock" style="margin-left:5px;"></i></span></button>
                        <ul class="dropdown-menu dropdown-menu-right mt-2" style="margin-top:24px !important;">
                           <li class="px-3 py-2">
                               <div class="text-center">
                                    <h5>Acesso restrito:</h5>
                                </div>
                               <form class="form" role="form" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                    <div class="form-group">
                                        <input id="email" type="email" placeholder="login" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password" placeholder="senha" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-block">ENTRAR</button>
                                        <a class="btn btn-link" style="margin-left: 70px" href="{{ route('telaEmail') }}">
                                        {{ __('Esqueceu sua senha?') }}
                                        </a>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div> 
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-sm-4">

            </div>
            <div class="col-sm-4">
            
            @foreach($unidades as $unidade)
            @if(isset($unidade->cnes) || $unidade->cnes !== null)
            @if($unidade->id != 9)
            <div class="card border-0 text-white" >
                <img id="img-unity" src="{{asset('img')}}/{{$unidade->path_img}}" class="card-img" alt="...">
                <div class="card-body text-center">
                    <a href="{{route('trasparenciaHome', $unidade->id)}}"  class="btn btn-outline-success">Saber mais +</a>
                </div>
            </div>
            @endif
            @endif
            @endforeach

            </div>
            <div class="col-sm-4">
            </div>
        </div>
    </div>

    <section id="unidades">
    <div class="container" style="margin-top:30px; margin-bottom:20px;">
        <div class="row">
            <div class="col-12 text-center">
                <span><h3 style="color:#65b345; margin-bottom:0px;">UNIDADES</h3></span>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <div class="progress" style="height: 3px;">
                    <div  class="progress-bar" role="progressbar" style="width: 100%; background-color: #65b345;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="col-2 text-center"></div>
            <div class="col-5">
                <div class="progress" style="height: 3px;">
                    <div  class="progress-bar" role="progressbar" style="width: 100%; background-color: #65b345;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container d-flex justify-content-between">
        <div class="row ">
            @foreach($unidades as $unidade)
            @if(!isset($unidade->cnes) || $unidade->cnes === null)
            @if($unidade->id != 9)
            <div class="col-sm-4">
                <div id="img-body" class="sborder-0 text-white text-center">
                    <img id="img-unity" src="{{asset('img')}}/{{$unidade->path_img}}" class="rounded-sm" alt="...">
                    <div class="card-body text-center">
                        <a href="{{route('trasparenciaHome', $unidade->id)}}"  class="btn btn-outline-success">Saber mais +</a>
                        <span class="font-weight-bold">{{$unidade->name}}</span>
                    </div>
                </div>
            </div>  
            @endif
            @endif
            @endforeach
        </div>
    </div>
    </section >

    <section id="sobre" style="margin-bottom:50px;">
    <div class="container" style="margin-top:30px; margin-bottom:20px;">
        <div class="row">
            <div class="col-12 text-center">
                <span><h3 style="color:#08509d; margin-bottom:0px;">SOBRE</h3></span>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <div class="progress" style="height: 3px;">
                    <div  class="progress-bar" role="progressbar" style="width: 100%; background-color: #08509d;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="col-2 text-center"></div>
            <div class="col-5">
                <div class="progress" style="height: 3px;">
                    <div  class="progress-bar" role="progressbar" style="width: 100%; background-color: #08509d;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container justify-content-center">
        <div class="row">
            <div class="col-12" style="font-family: Montserrat, sans-serif; ">
            <strong><h4 class="text-center" style="color: rgb(103, 101, 103);">Portal da Transparência</h4></strong>
            <p class="font-weight-normal text-justify">Fundada em 1945, a Sociedade Pernambucana de Combate ao Câncer (SPCC) é uma instituição filantrópica que teve suas atividades iniciadas em 1952, com a fundação do Hospital de Câncer de Pernambuco (HCP). Depois de 70 anos de serviços prestados à população pernambucana, especialmente a população mais carente, o Hospital de Câncer de Pernambuco iniciou uma nova fase em sua existência, marcada por um moderno modelo de gestão, sendo reconhecido, de forma inquestionável, como instituição de referência no tratamento do câncer e como modelo de gestão hospitalar a ser seguido e copiado.</p>

            <p class="font-weight-normal text-justify">Nesse cenário, em 2014 a SPCC, entidade mantenedora do Hospital de Câncer de Pernambuco, se viu preparada para ampliar sua atuação no setor de saúde e se qualificou como OSS (Organização Social de Saúde), iniciando a atuação na gestão de outras unidades de saúde.</p>

            <p class="font-weight-normal text-justify">Em 2016, com a ampliação dessa atuação, a SPCC se renovou e criou a Superintendência Geral das Unidades sob Gestão (SGUSG) para atuar no controle da gestão dessas novas unidades, que se somou à já existente Superintendência Geral do HCP (SGHCP),  responsável por atuar diretamente na gestão do Hospital de Câncer de Pernambuco.</p>
 
            <p class="font-weight-normal text-justify">No âmbito de Gestão por OSS, a SPCC executa desde o ano de 2014 a gestão das UPAE Padre Assis Neves no município de Belo Jardim/PE e da UPAE Áureo Bradley no município de Arcoverde/PE; e desde o ano de 2018 a gestão da UPAE Caruaru e do Hospital São Sebastião, todas unidades do Governo do Estado de Pernambuco. </p>

            <p class="font-weight-normal text-justify">Ainda, desde o ano de 2016 executa a gestão do Hospital da Mulher do Recife e da UPAE Arruda, ambos da Prefeitura Municipal do Recife.</p>
            </div>
        </div>
    </div>
    </section>
    <footer style="background-image: linear-gradient(to right, #80c52e , #65b345)">
        <div class="container-fluid text-center" style="position: relative; top: -25px; ">
            <div class="row" >
                <div class="col align-self-center">
                    <a href="#unidades" class="btn btn-success btn-lg" style="color: white; ">Voltar ao topo</a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container text-center">
                <div class="row">
                    <div class="col-sm">
                        <ul class="list-group" >
                            <li class="list-group-item border-0" style="background-color: rgba(185, 178, 178, 0);color:white;">HCPGESTAO@HCP.ORG.BR</li>
                            <li class="list-group-item border-0" style="background-color: rgba(185, 178, 178, 0);">
                                <img src="{{asset('img/imagem-link-site-hcp-rodape-v2.png')}}" alt="" srcset="">
                            </li>
                            <li class="list-group-item border-0" style="background-color: rgba(185, 178, 178, 0);">
                                <p style="font-size: 40px;letter-spacing: 10px;">
                                    <a class="text-decoration-none" target="_blank" href="https://www.facebook.com/sigahcp/">
                                        <i class="fab fa-facebook-square" style="color:white;"></i>
                                    </a>
                                    <a class="text-decoration-none" target="_blank" href="https://www.linkedin.com/company-beta/5314142/">
                                        <i class="fab fa-linkedin" style="color:white;"></i>
                                    </a>
                                    <a class="text-decoration-none" target="_blank" href="https://www.youtube.com/user/hcppernambuco">
                                        <i class="fab fa-youtube" style="color:white;"></i>
                                    </a>
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm">

                    </div>
                    <div class="col-sm ">
                        <ul class="list-group">
                        <li class="list-group-item border-0" style="background-color: rgba(185, 178, 178, 0);">
                            <img src="{{asset('img/logo-hcp-gestao-oss-v2.png')}}" alt="" srcset="">
                        </li>
                        <li class="list-group-item border-0" style="background-color: rgba(185, 178, 178, 0); margin-top: 30px;">
                            <img src="{{asset('img/logo-ibross-rodape.png')}}" alt="" srcset="">
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>



    </body>
</html>
