@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">ESTRUTURA ORGANIZACIONAL</h5>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-12">
			<h3 style="font-size: 15px;"><strong>REGIMENTO INTERNO</strong></h3>
			<h3 style="font-size: 12px;"></h3>
			<ul class="list-inline">
				@if(empty($reg[0]))
				<li class="list-inline-item">
					<h5 style="font-size: 12px;">Regimento Interno:</h5>
				</li>
				@else
				<li class="list-inline-item">
					<h5 style="font-size: 12px;">{{ $reg[0]->title }}</h5>
				</li>
				@endif
				@if($qtd > 0)
				<li class="list-inline-item"><a href="{{asset('storage')}}/{{$reg[0]->file_path}}" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-file-download" style="margin-right: 5px;"></i>Download</a></li>
				@endif
				@if(Auth::check())
				 @foreach ($permissao_users as $permissao)
				  @if(($permissao->permissao_id == 2) && ($permissao->user_id == Auth::user()->id))
				   @if ($permissao->unidade_id == $unidade->id)
				    <li class="list-inline-item"><a href="{{route('regimentoCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></li>
				   @endif
				  @endif
				 @endforeach 
				@endif
			</ul>
		</div>
	</div>
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12">
			<h3 style="font-size: 15px;"><strong>ORGANOGRAMA</strong></h3>
			<h5 class="mt-4" style="font-size: 12px;">Estrutura Organizacional {{ stristr($unidade->name, 'Unidade') == true || stristr($unidade->name, 'Sociedade') == true ? 'da' : 'do'}} {{$unidade->name}}</h5>
            <li class="list-inline-item">
			    <h5 style="font-size: 12px;">Organograma do HCP Gestão (Clique no botão para abrir)</h5>
			</li>
			@if(sizeof($arqOrgano) > 0)
			<li class="list-inline-item"><a href="{{asset('storage')}}/{{$arqOrgano[0]->file_path}}" class="btn btn-success btn-sm" target="_blank"><i class="fas fa-file-download" style="margin-right: 5px;"></i>Download</a></li>
			@endif
				@if(Auth::check())
				 @foreach ($permissao_users as $permissao)
				  @if(($permissao->permissao_id == 2) && ($permissao->user_id == Auth::user()->id))
				   @if ($permissao->unidade_id == $unidade->id)
    				<li class="list-inline-item"><a href="{{route('organograma', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></li>
    			   @endif
    			  @endif
    			 @endforeach 
				@endif
			</ul>
			@if(Auth::check())
    			@foreach ($permissao_users as $permissao)
        			@if(($permissao->permissao_id == 2) && ($permissao->user_id == Auth::user()->id))
            			@if ($permissao->unidade_id == $unidade->id)
            			<h3 style="font-size: 15px;"><strong>ESTRUTURA ORGANIZACIONAL</strong></h3>
            			@endif
        			@endif
    			@endforeach
			@endif
			@if($unidade->id > 1)
			<div class="row" style="overflow: auto;">
			<table class="table table-sm" >
				<thead class="bg-success">
					<tr>
						<th scope="col">Cargo</th>
						<th scope="col">Nome</th>
						<th scope="col">E-mail</th>
						<th scope="col">Telefone</th>
					</tr>
				</thead>
				<tbody>
					@foreach($estruturaOrganizacional as $organizacional)
					<tr>
						<td style="font-size: 11px;">{{$organizacional->cargo}}</td>
						<td style="font-size: 11px;">{{$organizacional->name}}</td>
						<td style="font-size: 11px;">{{$organizacional->email}}</td>
						<td style="font-size: 11px;">{{$organizacional->telefone}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			</div>
			@if(Auth::check())
    			@foreach ($permissao_users as $permissao)
        			@if(($permissao->permissao_id == 2) && ($permissao->user_id == Auth::user()->id))
            			@if ($permissao->unidade_id == $unidade->id)
            			<div class="d-flex justify-content-end">
            				<li class="list-inline-item"><a href="{{route('organizacionalCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></li>
            			</div>
            			@endif
        			@endif
    			@endforeach
			@endif
			@endif
		</div>
	</div>
</div>
</div>
</div>

@endsection