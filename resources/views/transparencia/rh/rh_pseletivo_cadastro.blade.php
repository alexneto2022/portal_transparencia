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
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#SELETIVO" aria-expanded="true" aria-controls="SELETIVO">
						PROCESSO SELETIVO <i class="fas fa-tasks"></i>
					</a>				
					<div class="card-body border-0" style="background-color: #fafafa">
						<p>
							@foreach ($docSelectiveProcess->pluck('year')->unique() as $ano)
								<a class="btn btn-success" data-toggle="collapse" href="#{{$ano}}SELETIVO" role="button" aria-expanded="false" aria-controls="{{$ano}}SELETIVO">{{$ano}}</a>
							@endforeach
						</p>
						@foreach ($docSelectiveProcess->pluck('year')->unique() as $ano)
						<div class="collapse border-0" id="{{$ano}}SELETIVO" >
							<div class="card border-0 card-body" style="background-color: #fafafa">
								<h6 class=""><strong>{{$ano}}</strong></h6>
								<table class="table">
									<tbody>
										@foreach ($docSelectiveProcess->sortBy('ordering') as $item)
										@if ($item->year === $ano)
											<tr>
												<td style="font-size: 10px;" class="text-left border-0" >{{$item->title}}</td>
												<td class="border-0"><i class="fas fa-arrow-right"></i></td>
												<td class="border-0"><a target="_blank" href="{{asset('storage/')}}/{{$item->file_path}}" class="badge badge-success">Visualizar</a></td>
												<td><center> <a class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('processoSExcluir', array($unidade->id, $item->id))}}" ><i class="fas fa-times-circle"></i></a> </center> </td>
											</tr>
										@endif
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						@endforeach
						<p><a href="{{route('transparenciaRecursosHumanos', $unidade->id)}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i></a>
						   <a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('processoSNovo', $unidade->id)}}"> Novo <i class="fas fa-check"></i> </a></p>
						<p class="card-text"><small class="text-muted">Última atualização {{date("d/m/Y", strtotime($docSelectiveProcess->max('updated_at')))}}</small></p>
					</div>
				</div>
			</div>
        </div>
		<div class="col-md-1 col-sm-0"></div>
    </div>
</div>
@endsection