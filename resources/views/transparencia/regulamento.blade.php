@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" >
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">REGULAMENTOS PRÓPRIOS</h5>
			@if(Auth::check())
			 @foreach ($permissao_users as $permissao)
			  @if(($permissao->permissao_id == 16) && ($permissao->user_id == Auth::user()->id))
			   @if ($permissao->unidade_id == $unidade->id)	
				 <p align="right"><a href="{{route('regulamentoCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>
			   @endif
			  @endif 
			 @endforeach 
			@endif
		</div>
	</div>	
	<div class="row justify-content-around" style="margin-top: 25px;">
		@foreach($manuais as $manual)
		<div class="col-md-2 col-sm-12">
			<div class="card-group">
				<div class="card border-0" style="max-width: 12rem; background-color: #fafafa;">
					<a target="_blank" href="{{asset('storage')}}/{{$manual->path_file}}">
						<img class="card-img-top border border-secondary" src="{{asset('img')}}/{{$manual->path_img}}" alt="Card image cap">
					</a>
					<p style="font-size: 11px; color: black;"><small>{{$manual->title}}</small></p>
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