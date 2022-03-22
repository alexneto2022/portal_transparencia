@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
    <div class="row" style="margin-bottom: 25px; margin-top: 25px;">
        <div class="col-md-12 text-center">
            <h5  style="font-size: 18px;">RELATÓRIO ASSISTENCIAL</h5>
			@if(Auth::check())
			 @foreach ($permissao_users as $permissao)
			  @if(($permissao->permissao_id == 8) && ($permissao->user_id == Auth::user()->id))
			   @if ($permissao->unidade_id == $unidade->id)
				@if($unidade->id == 8)
				<p align="right"><a href="{{route('assistencialCovidCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>
			    @else
				<p align="right"><a href="{{route('assistencialCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p>
				@endif
		       @endif
			  @endif 
			 @endforeach 
			@endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="d-flex justify-content-around">
                @foreach($anosRef as $year)
                <button class="btn btn-success btn-lg " type="button" data-toggle="collapse" data-target="#{{$year}}" aria-expanded="false" aria-controls="{{$year}}">
                    {{$year}}
                </button>
                @endforeach
            </div>
            @foreach($anosRef as $year)
            <div class="collapse border-0" id="{{$year}}" style="margin-top: 8px;">
                <div class="card border-0 card-body" style="background-color: #fafafa;">
                    <div class="d-flex justify-content-around text-center">
                        <div class="col-md-6">
                            <div class="container" style="margin-bottom: 10px;">
                                 <h5 class="text-success"><strong>{{$year}}</strong></h5>
								 @if(Auth::check())
									  <a class="text-success" href="{{route('exportAssistencialMensal',['id'=> $unidade->id, 'year'=> $year])}}" title="Download"><img src="{{asset('img/csv.png')}}" alt="" width="60"></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  <a class="text-danger" href="{{route('assistencialPdf',['id'=> $unidade->id, 'year'=> $year])}}" title="Download"><img src="{{asset('img/pdf.png')}}" alt="" width="60"></a> </td>
								 @else
									<a href="{{route('visualizarAssistencial', ['id' => $unidade->id, 'year' => $year])}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Visualizar <i class="fas fa-bars"></i> </a> 
								 @endif
					       </div>
                        </div>
                    </div>
               </div>
            </div>
            @endforeach
			@if($unidade->id == 8)
				<div class="row" style="margin-top: 25px;">
					<div class="col-md-2 col-sm-0"></div>
					<div class="col-md-8 col-sm-20 text-center">
						@foreach ($assistencialCovid->pluck('ano')->unique() as $ano)
						<a class="btn btn-success" data-toggle="collapse" href="#{{$ano}}" role="button" aria-expanded="false" aria-controls="{{$ano}}">{{$ano}}</a>
						@endforeach
						@foreach ($assistencialCovid->pluck('ano')->unique() as $financialReport)
						<div class="collapse border-0" id="{{$financialReport}}" >
							<table class="table" style="margin-left: -200px;">
								@foreach ($assistencialCovid as $item)
								@if ($item->ano == $financialReport)
								  <tr>
								    <td><p style="margin-top: 10px; color: #000000;">{{ $item->mes }}</p></td>
								 	<td><a href="{{asset('storage')}}/{{$item->file_path}}" style="width: 650px;" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">{{$item->titulo}} - <span class="badge badge-secondary">{{$item->mes}}/{{$item->ano}}</span> <i style="color:#65b345" class="fas fa-cloud-download-alt"></i></a></td>
								  </tr>
								@endif	
								@endforeach
							</table>
						</div>
						@endforeach
						<div class="container" style="margin-top: 15px;">
							<h2 style="font-size: 80px; color:#65b345"><i class="fas fa-file-pdf"></i></h2>
						</div>
					</div>
					<div class="col-md-2 col-sm-0"></div>
				</div>
			</div>
			@endif			
	    </div> 
		<div class="col-md-2"></div>
    </div>
</div>
@endsection