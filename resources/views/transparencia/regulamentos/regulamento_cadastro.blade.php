@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" >
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">REGULAMENTOS PRÓPRIOS</h5>
			<p align="right"><a href="{{route('transparenciaRegulamento', $unidade->id)}}" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
			<a href="{{route('regulamentoNovo', $unidade->id)}}" class="btn btn-dark btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a></p>
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
	<div class="row justify-content-around" style="margin-top: 25px;">
		@foreach($manuais as $manual)
		<div class="col-md-2 col-sm-12">
			<div class="card-group">
				<div class="card border-0" style="max-width: 12rem; background-color: #fafafa;">
					<a target="_blank" href="{{asset('storage/app/public')}}/{{$manual->path_file}}">
						<img class="card-img-top border border-secondary" src="{{asset('img')}}/{{$manual->path_img}}" alt="Card image cap">
					</a>
					<p style="font-size: 11px; color: black;"><small>{{$manual->title}}</small></p>
					<p style="font-size: 11px;"><a href="{{ route('regulamentoExcluir', array($unidade->id, $manual->id))}}" class="btn btn-danger btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Excluir <i class="fas fa-times-circle"></i> </a></p></p>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
<blockquote class="blockquote" style="margin-top: 60px;">
	<footer class="blockquote-footer">Clique no regulamento para visualizar!</footer>
</blockquote>
@endsection