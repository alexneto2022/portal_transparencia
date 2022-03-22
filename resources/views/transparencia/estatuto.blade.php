@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" style="margin-top: 25px;">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8 text-center">
			<h5  style="font-size: 18px;">ESTATUTO SOCIAL E ATAS DO ESTATUTO SOCIAL</h5> 
			@if(Auth::check())
			 @foreach ($permissao_users as $permissao)
			  @if(($permissao->permissao_id == 14) && ($permissao->user_id == Auth::user()->id))
			   @if ($permissao->unidade_id == 1)
				 <p style="margin-right: -590px;"><a href="{{route('estatutoCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>
			   @endif 
			  @endif
		     @endforeach		
			@endif
			<ul class="list-group" style="font-size: 13px; margin-top: 25px;">
				@foreach($estatutos as $estatuto)
				<li class="list-group-item d-flex justify-content-between align-items-center border-top" style="background-color: #fafafa">
			    	<strong>{{$estatuto->name}}</strong>
			    	<a href="{{asset('storage')}}/{{$estatuto->path_file}}" target="_blank" class="btn btn-success btn-sm" style="font-size: 12px;">Download <i class="fas fa-file-download" style="margin-left: 5px;"></i></a>
			  	</li>
				@endforeach
			</ul>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>
@endsection