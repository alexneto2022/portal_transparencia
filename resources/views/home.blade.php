@extends('layouts.app')

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        <title>Portal da Transparencia - HCP</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
        <style>
        .navbar .dropdown-menu .form-control {
            width: 300px;
        }
        </style>
    </head>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3" style="background-image: linear-gradient(to right, #28a745, #28a745); height: auto; border-radius: 175px 175px 175px 175px;">
        </div>
        <div class="col-md-3" style="background-image: linear-gradient(to right, #28a745, #28a745); height: auto; border-radius: 175px 175px 175px 175px;">        
        </div>
        <div class="col-md-3" style="background-image: linear-gradient(to right, #28a745, #28a745); height: auto; border-radius: 175px 175px 175px 175px;">
        </div>
        <div class="col-md-3" style="background-image: linear-gradient(to right, #28a745, #28a745); height: auto; border-radius: 175px 175px 175px 175px;">
            
        </div>
    </div>
</div>

  <div class="container">
        <div class="row">
            <div class="col-sm-12">
			@if ($errors->any())
			<div class="alert alert-success">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
	        @endif
            </div>
			<div class="col-sm-4">
			</div>
            <div class="col-sm-4">
			            
            @foreach($unidades as $unidade)
            @if(isset($unidade->cnes) || $unidade->cnes !== null)
            <div class="card border-0 text-white" >
                <img id="img-unity" src="{{asset('img')}}/{{$unidade->path_img}}" class="card-img" alt="...">
                <div class="card-body text-center">
                    <a href="{{route('trasparenciaHome', $unidade->id)}}"  class="btn btn-outline-success">Saber mais +</a>
                </div>
            </div>
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
            @endforeach
        </div>
    </div>
 
    </section >    
@endsection