@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">OUVIDORIA</h3>
			<p style="margin-right: -520px;"><a href="{{route('transparenciaOuvidoria', array($unidade->id,1))}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>&nbsp;&nbsp;&nbsp;<a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('ouvidoriaNovo', $unidade->id)}}"> Novo <i class="fas fa-check"></i> </a></p>
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
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div id="accordion">
				<div class="card ">
					<div id="1" class="" aria-labelledby="headingOne" data-parent="#accordion">
						@foreach($ouvidorias as $ouvidoria)
						<div class="card-body"  style="font-size: 14px;">
							<table class="table table-sm" border="0">
							    <tr>
								 <td> <strong>Responsável:</strong> </td>
								 <td> <strong>E-mail:</strong> </td>
								 <td> <strong>Telefone:</strong> </td>
								 <td> <strong>Alterar:</strong> </td>
								 <td> <strong>Excluir:</strong> </td>
								</tr>
								<tr>
								 <td> {{ $ouvidoria->responsavel }} </td> 
								 <td> {{ $ouvidoria->email }} </td>
								 <td> {{ $ouvidoria->telefone }} </td>
								 <td> <a class="btn btn-info btn-sm" href="{{route('ouvidoriaAlterar', array($unidade->id, $ouvidoria->id))}}"><i class="fas fa-edit"></i></a> </td>
								 <td> <a class="btn btn-danger btn-sm" href="{{route('ouvidoriaExcluir', array($unidade->id, $ouvidoria->id))}}"><i class="fas fa-times-circle"></i></a> </td>
								</tr>
							</table>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-2 col-sm-0"></div>
	</div>
</div>
@endsection