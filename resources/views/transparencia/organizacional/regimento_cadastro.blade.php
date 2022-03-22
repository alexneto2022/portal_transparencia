@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">REGIMENTO INTERNO</h5>
		</div>
	</div>	
	<div class="row"> 
			@if ( empty($regimentos[0]) )
			<div class="col-md-12">
				<p align="right"><a href="{{route('regimentoNovo', $unidade->id)}}" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a></p>
			</div>
			@else
			<table class="table table-sm ">
				<thead class="bg-success">
					<tr>
						<th scope="col">Título</th>
						<th scope="col">Arquivo</th>
						<th scope="col">Excluir</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="font-size: 15px;">{{$regimentos[0]->title}}</td>
						<td style="font-size: 15px;">{{$regimentos[0]->file_path}}</td>
						<td style="font-size: 15px;"><a class="btn btn-danger btn-sm" href="{{route('regimentoExcluir', array($unidade->id, $regimentos[0]->id))}}" ><i class="fas fa-times-circle"></i></td> 
					</tr>
				</tbody>
			@endif	
		</table>
	</div>
</div>

@endsection