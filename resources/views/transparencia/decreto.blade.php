@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" style="margin-top: 25px;">
	<div class="row" style="margin-bottom: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">DECRETO DE QUALIFICAÇÃO</h5>
			@if(Auth::check())
			 @foreach ($permissao_users as $permissao)
			  @if(($permissao->permissao_id == 15) && ($permissao->user_id == Auth::user()->id))
			   @if ($permissao->unidade_id == 1)
				 <p align="right"><a href="{{route('decretoCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>
			   @endif
			  @endif
			 @endforeach 
		    @endif
		</div>
	</div>	
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