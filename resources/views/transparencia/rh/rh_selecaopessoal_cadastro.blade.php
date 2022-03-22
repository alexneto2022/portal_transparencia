@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">RECURSOS HUMANOS</h3>
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
		<div class="col-md-1 col-sm-0"></div>
		<div class="col-md-10 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						SELEÇÃO DE PESSOAL <i class="fas fa-check-circle"></i>
					</a>				
						@foreach ($selecaoPessoal->pluck('ano')->unique()->toArray() as $ano)
							<p>
								<div class="row">
									<div class="container">
										<a class="btn btn-success btn-sm" data-toggle="collapse" href="#{{$ano}}" role="button" aria-expanded="false" aria-controls="{{$ano}}">
											Seleção - {{$ano}} <i class="fas fa-user-md"></i> <i class="fas fa-user-tie"></i>
										</a>
									</div>
								</div>
							</p>
						  <div class="collapse border-0" id="{{$ano}}">
							<div class="card border-0 card-body">
								<table class="table table-hover table-sm" style="font-size: 13px;">
									<thead style="background-color: #64B346; color: white;">
									  <tr>
										<th scope="col">Cargo</th>
										<th scope="col">Quantidade</th>
										<th scope="col">Alterar</th>
										<th scope="col">Excluir</th>
									  </tr>
									</thead>
									<tbody>
										@foreach ($selecaoPessoal as $selecao)
										@if ($selecao->ano === $ano)
											<tr>
												<td>{{$selecao->cargos->cargo_name}}</td>
												<td>{{$selecao->quantidade}}</td>
												<td><center> <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('selecaoPAlterar', array($unidade->id, $selecao->id))}}" ><i class="fas fa-edit"></i></a> </center> </td>
												<td><center> <a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('selecaoPExcluir', array($unidade->id, $selecao->id))}}" ><i class="fas fa-times-circle"></i></a> </center> </td>
											</tr>
										@endif
										@endforeach
											<tr>
												<td><strong>Total</strong></td>
												<td><strong>{{$selecaoPessoal->where('ano', $ano)->pluck('quantidade')->sum()}}</strong></td>
											</tr>
									</tbody>
								</table>
								
							</div>
						   </div>
						@endforeach
						<p><br /><a href="{{route('transparenciaRecursosHumanos', $unidade->id)}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i></a>
								 <a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('selecaoPNovo', $unidade->id)}}"> Novo <i class="fas fa-check"></i> </a> </p>
						<p class="card-text"><small class="text-muted">Última atualização {{date("d/m/Y", strtotime($selecaoPessoal->max('updated_at')))}}</small></p>
				</div>
			</div>
        </div>
		<div class="col-md-1 col-sm-0"></div>
    </div>
</div>
@endsection