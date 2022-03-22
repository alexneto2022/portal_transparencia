@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">DEMONSTRATIVOS FINANCEIROS</h3>
			<p align="right"><a href="{{route('transparenciaDemonstrative', array($unidade->id,1))}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>&nbsp;&nbsp; <a href="{{route('demonstrativoFinanNovo', $unidade->id)}}" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a></p>
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
			
			@foreach ($financialReports->pluck('ano')->unique() as $ano)
				<a class="btn btn-success" data-toggle="collapse" href="#{{$ano}}" role="button" aria-expanded="false" aria-controls="{{$ano}}">{{$ano}}</a>
			@endforeach

			@foreach ($financialReports->pluck('ano')->unique() as $financialReport)
			<div class="collapse border-0" id="{{$financialReport}}" >
				<div class="card card-body border-0" style="background-color: #fafafa">
					@foreach ($financialReports as $item)
					@if ($item->ano == $financialReport)
						<div class="list-group" style="font-size: 15px;padding: 2px 2px;">
					    <table class="table table-sm">
						 <tr>
						  <td> <strong>Título: </strong> </td>
						  <td> <strong>Excluir:</strong> </td>
						 </tr>
						 <tr>
						  <td>
							<a href="{{asset('storage/')}}/{{$item->file_path}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">{{$item->title}} -<span class="badge badge-secondary">{{$item->mes}}/{{$item->ano}}</span> <i style="color:#65b345" class="fas fa-cloud-download-alt"></i></a>
						  </td>
						  <td>
							<a class="btn btn-danger btn-sm" href="{{route('demonstrativoFinanExcluir', array($unidade->id, $item))}}"><i class="fas fa-times-circle"></i></a>
						  </td>
						 </tr>
						</table>
						</div>
					@endif	
					@endforeach
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