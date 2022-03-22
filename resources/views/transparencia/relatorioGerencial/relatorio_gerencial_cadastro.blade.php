@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">RELATÓRIO MENSAL DE EXECUÇÃO</h3>
			<p align="right"><a href="{{route('transparenciaRelatorioGerencial', array($unidade->id,1))}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>&nbsp;&nbsp;&nbsp;<a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('relatorioGerencialNovo', $unidade->id)}}"> Novo <i class="fas fa-check"></i></a></p>
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
		<div class="col-md-8 col-sm-12">
			<div class="accordion" id="accordionExample">
				@foreach ($demonstrativoContaveis->pluck('ano')->unique() as $ano)
				<div class="card border-bottom" style="margin-bottom: 5px;">
					<a class="btn text-decoration-none" type="button" data-toggle="collapse" href="#{{$ano}}Competência" aria-expanded="true" aria-controls="{{$ano}}Competência">
						<strong>Competência {{$ano}}</strong> <i style="color:#65b345;" class="fas fa-search-dollar"></i>
					</a>
				  <div id="{{$ano}}Competência" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
					<div class="card-body">
						@foreach ($demonstrativoContaveis as $demonstrativoContabel)
						@if ($ano === $demonstrativoContabel->ano)
							<table class="table table-sm">
						        <tr> 
								 <td colspan="3"> {{ $demonstrativoContabel->mes }} </td>
								</tr>
								<tbody>
								<tr>
									<td class="border-0 text-left" style="width: 400px;">{{$demonstrativoContabel->title}}</td>
									<td class="border-0 text-right"><a href="{{asset('storage/')}}/{{$demonstrativoContabel->file_path}}" target="_blank" class="badge badge-success">Download</a></td>
									<td class="border-0 text-right"><a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('relatorioGerencialExcluir', array($unidade->id, $demonstrativoContabel->id))}}" > Excluir <i class="fas fa-times-circle"></i></a>  </td>
								</tr>
								</tbody>
							</table>
						@endif
						@endforeach
					</div>
				  </div>
				</div>
				@endforeach
			</div>
        </div>
		<div class="col-md-2 col-sm-0"></div>
    </div>
</div>
@endsection