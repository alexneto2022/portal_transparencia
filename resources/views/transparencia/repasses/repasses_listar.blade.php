@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">REPASSES RECEBIDOS</h3>
		</div>
	</div>
	@if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
	@endif 
		<p>
			@foreach ($anoRepasses as $ano)
			<a class="btn btn-success btn-sm" data-toggle="collapse" href="#{{$ano}}" role="button" aria-expanded="false" aria-controls="{{$ano}}">
			<img src="{{asset('img/bank.png')}}" alt="" width="30" style="margin-right: 10px;"><strong>REPASSES</strong> {{$ano}} 
			</a> 
			@endforeach
		  </p>
		  @foreach ($anoRepasses as $ano)
		  
		  <div class="collapse border-0" id="{{$ano}}" >
			<div class="card card-body border-0" style="background-color: #fafafa !important">
				<div class="row" style="margin-top: 25px;">
					<div class="col-md-12 col-sm-12 text-center">
						<div class="d-flex justify-content-end" style="margin-bottom: 10px;">
							<span class="badge badge-success"><a href="{{route('repassesExport', ['id'=> $unidade->id, 'year' => $ano])}}"><span class="badge badge-success">Download EXCEL</span></a>
						</div>
						<table class="table table-hover table-sm" style="font-size: 15px;">
							<thead class="bg-success">
							<tr>
								<th scope="col">Mês</th>
								<th scope="col">Ano</th>
								<th scope="col">Contratado</th>
								<th scope="col">Recebido</th>
								<th scope="col">Desconto</th>
								<th scope="col">Saldo a receber</th>
							</tr>
							</thead>
							<tbody>
								@foreach ($repasses as $repasse)
									@if($repasse->ano === $ano && $unidade->id == $repasse->unidade_id)
									<tr>
										<td>{{$repasse->mes}}</td>
										<td>{{$ano}}</td>
										<td>{{ $ano === $repasse->ano ? "R$ ".number_format($repasse->contratado, 2,',','.'): '' }}</td>
										<td>{{ $ano === $repasse->ano ? "R$ ".number_format($repasse->recebido, 2,',','.'): '' }}</td>
										<td>{{ $ano === $repasse->ano ? "R$ ".number_format($repasse->desconto, 2,',','.'): '' }}</td>
										<td>{{ $ano === $repasse->ano ? "R$ ".number_format($repasse->contratado-$repasse->recebido, 2,',','.'): '' }}</td>
									</tr>
									@endif
								@endforeach
								<tr class="table-success">
									<td colspan="2"><strong>Total</strong></td>
									<td><strong>{{"R$ ".number_format($repasses->where('ano', $ano)->pluck('contratado')->sum(), 2,',','.') }}</strong></td>
									<td><strong>{{"R$ ".number_format($repasses->where('ano', $ano)->pluck('recebido')->sum(), 2,',','.') }}</strong></td>
									<td><strong>{{"R$ ".number_format($repasses->where('ano', $ano)->pluck('desconto')->sum(), 2,',','.') }}</strong></td>
									<td><strong>{{"R$ ".number_format(($repasses->where('ano', $ano)->pluck('contratado')->sum()-$repasses->where('ano', $ano)->pluck('recebido')->sum()), 2,',','.') }}</strong></td>
								</tr>
							
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>			  
		  @endforeach

</div>
@endsection