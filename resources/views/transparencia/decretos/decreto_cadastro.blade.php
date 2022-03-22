@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" style="margin-top: 25px;">
	<div class="row" style="margin-bottom: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">DECRETO DE QUALIFICAÇÃO</h5>
			<p align="right"><a href="{{route('transparenciaDecreto', $unidade->id)}}" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
			<a href="{{route('decretoNovo', $unidade->id)}}" class="btn btn-dark btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a></p>
		</div>
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
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-5">
			<div class="card border-0" style="width: 22rem; background-color: #fafafa;">
				<img class="card-img-top" src="{{asset('img/logoGov.png')}}" alt="Card image cap">
				<div class="card-body border-0">
					<ul class="list-group">
						@foreach($decretos as $decreto)
						@if($decreto->kind === 'Governo')
						<li class="list-group-item d-flex justify-content-between align-items-center  border-0" style="background-color: #fafafa;">
							<h6 style="font-size: 12px;">{{$decreto->title}}</h6> <a href="{{asset('storage/')}}/{{$decreto->path_file}}" target="_blank" class="badge badge-success">Download</a>
							&nbsp;&nbsp;&nbsp;<a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('decretoExcluir', array($unidade->id, $decreto->id))}}" > <i class="fas fa-times-circle"></i></a>
						</li>
						@endif
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<div class="card border-0" style="width: 22rem; background-color: #fafafa;">
				<img class="card-img-top" src="{{asset('img/logo-prefeitura-recife.png')}}" alt="Card image cap">
				<div class="card-body">
					<ul class="list-group">
						@foreach($decretos as $decreto)
						@if($decreto->kind === 'Municipio')
						<li class="list-group-item d-flex justify-content-between align-items-center  border-0" style="background-color: #fafafa;">
							<h6 style="font-size: 12px;">{{$decreto->title}}</h6> <a  href="{{asset('storage/')}}/{{$decreto->path_file}}" target="_blank" class="badge badge-success">Download</a>
							&nbsp;&nbsp;&nbsp;<a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('decretoExcluir', array($unidade->id, $decreto->id))}}" > <i class="fas fa-times-circle"></i></a>
						</li>
						@endif
						@endforeach
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-1">
		</div>
	</div>
</div>
@endsection