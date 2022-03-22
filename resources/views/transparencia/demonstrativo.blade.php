@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">DEMONSTRATIVOS FINANCEIROS</h3>
			@if(Auth::check())
			 @foreach ($permissao_users as $permissao)
			  @if(($permissao->permissao_id == 7) && ($permissao->user_id == Auth::user()->id))
			   @if ($permissao->unidade_id == $unidade->id)
				<p align="right"><a href="{{route('demonstrativoFinanCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>
			   @endif
			  @endif 
			 @endforeach 
			@endif
		</div>
	</div>
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-12 text-center">
			@foreach ($financialReports->pluck('ano')->unique() as $ano)
				<a class="btn btn-success" data-toggle="collapse" href="#{{$ano}}" role="button" aria-expanded="false" aria-controls="{{$ano}}">{{$ano}}</a>
			@endforeach
			@foreach ($financialReports->pluck('ano')->unique() as $financialReport)
			<div class="collapse border-0" id="{{$financialReport}}" >
				<div class="card card-body border-0" style="background-color: #fafafa">
					@foreach ($financialReports as $item)
					@if ($item->ano == $financialReport)
						<div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage')}}/{{$item->file_path}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">{{$item->title}} -<span class="badge badge-secondary">{{$item->mes}}/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						 @if($item->ano == 2020 && ($unidade->id == 2 || $unidade->id == 8)) * @endif 
						 @if($item->mes == 9 && $unidade->id == 4 && ($item->ano == 2020)) * @endif 
						 @if($item->mes == '10' && $unidade->id == 5 && ($item->ano == '2020')) * @endif
						 @if($item->mes == '10' && $unidade->id == 6 && ($item->ano == '2020')) * @endif
						 @if($item->mes == '11' && $unidade->id == 5 && ($item->ano == '2020')) * @endif
						 @if($item->mes == '12' && $unidade->id == 5 && ($item->ano == '2020')) * @endif
						</a>
						</div>
					@endif	
					@endforeach
					@if($financialReport == '2020' && ($unidade->id == 2 || $unidade->id == 8))
					<div class="list-group" style="font-size: 15px;padding: 2px 2px;">
					 * Aguardar validação do Contratante
					</div>
					@endif
					@if($financialReport == '2020' && ($unidade->id == 4))
					<div class="list-group" style="font-size: 15px;padding: 2px 2px;">
					 * Aguardar validação do Contratante
					</div>
					@endif
					@if($item->ano == '2020' && $unidade->id == 5)
					<div class="list-group" style="font-size: 15px;padding: 2px 2px;">
					 * Aguardar validação do Contratante
					</div>
					@endif
					@if($item->ano == '2020' && $unidade->id == 6)
					<div class="list-group" style="font-size: 15px;padding: 2px 2px;">
					 * Aguardar validação do Contratante
					</div>
					@endif
				</div>
			</div>
			@endforeach
			<div class="container" style="margin-top: 15px;">
				<h2 style="font-size: 80px; color:#65b345"><i class="fas fa-file-pdf"></i></h2>
			</div>
			
        </div>
		<div class="col-md-2 col-sm-0"></div>
    </div>
</div>
@endsection