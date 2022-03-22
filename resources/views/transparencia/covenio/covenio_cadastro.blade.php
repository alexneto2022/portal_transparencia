@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">COVÊNIO</h3>
			<p style="margin-right: -520px;"><a href="{{route('transparenciaCovenio', array($unidade->id,1))}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>&nbsp;&nbsp;&nbsp;<a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('covenioNovo', $unidade->id)}}"> Novo <i class="fas fa-check"></i> </a></p>
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
			@if($unidade->id == 1)
				<div class="card ">
					<div class="card-header" id="headingOne">
							<h5 class="mb-0">
								<a class="btn btn-link text-dark no-underline" data-toggle="collapse" data-target="#2" aria-expanded="true" aria-controls="2">
									Hospital do Câncer de Pernambuco
								</a>
								@if(Auth::check())
							      
							    @endif
							</h5>
					</div>
					<div id="1" class="collapse {{$unidade->id == 1? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordion">
						@foreach($covenios as $covenio)
						@if($covenio->unidade_id == 1)
						<div class="card-body"  style="font-size: 14px;">
							<table class="table table-sm" border="0">
							    <tr>
								 <td> <strong>Título:</strong> </td>
								 <td> &nbsp;&nbsp; </td>
								 <td> <strong>Excluir:</strong> </td>
								</tr>
								<tr>
								 <td width="400"> <a class="text-dark no-underline" target="_blank" href="{{asset('storage/')}}/{{$covenio->path_file}}"><strong>{{$covenio->path_name}} <i style="color: #28a745;" class="fas fa-download"></i></strong></a> </td>
								 <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
								 <td> <a class="btn btn-danger btn-sm" href="{{route('covenioExcluir', array($unidade->id, $covenio->id))}}"><i class="fas fa-times-circle"></i></a> </td>
								</tr>
							</table>
						</div>
						@endif
						@endforeach
					</div>
				</div>
			@endif	
			</div>
		</div>
		<div class="col-md-2 col-sm-0"></div>
	</div>
</div>
@endsection