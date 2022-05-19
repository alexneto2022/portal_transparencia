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
					@if($financialReport == '2022' && $unidade->id == 2)
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage/COVID.rar')}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas - COVID -<span class="badge badge-secondary">1/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage/Maternidade.rar')}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas - MATERNIDADE -<span class="badge badge-secondary">1/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage/COVID-022022.rar')}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas - COVID -<span class="badge badge-secondary">2/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage/MATERNIDADE-022022.rar')}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas - MATERNIDADE -<span class="badge badge-secondary">2/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage/COVID-032022.rar')}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas - COVID -<span class="badge badge-secondary">3/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage/MATERNIDADE-032022.rar')}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas - MATERNIDADE -<span class="badge badge-secondary">3/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					@endif
					@if($financialReport == '2022' && $unidade->id == 3)
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="https://sei.pe.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=85424&infra_hash=558b08c37e712a3d6ee92ccfc7cf2940" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas -<span class="badge badge-secondary">1/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="https://sei.pe.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=90085&infra_hash=2642f874b531ae14ab0fe708d237f41e" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas -<span class="badge badge-secondary">2/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					@endif
					@if($financialReport == '2022' && $unidade->id == 4)
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="https://sei.pe.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=85426&infra_hash=d12f67f9f9d7ef97eacbd654b75ec2cb" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas -<span class="badge badge-secondary">1/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="https://sei.pe.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=90183&infra_hash=5f380d096d8648944403c71922d13530" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas -<span class="badge badge-secondary">2/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					@endif
					@if($financialReport == '2022' && $unidade->id == 5)
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage/01.JANEIRO 2022.rar')}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas -<span class="badge badge-secondary">1/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage/ARRUDA 022022.rar')}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas -<span class="badge badge-secondary">2/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage/ARRUDA 032022.rar')}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas -<span class="badge badge-secondary">3/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					@endif
					@if($financialReport == '2022' && $unidade->id == 6)
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="https://sei.pe.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=85418&infra_hash=1828a277add308cf7900a8cbeeb9790e" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas -<span class="badge badge-secondary">1/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="https://sei.pe.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=90308&infra_hash=08e21f1f6d6b8393d59d01541de226a7" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas -<span class="badge badge-secondary">2/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					@endif
					@if($financialReport == '2022' && $unidade->id == 7)
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="https://sei.pe.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=85419&infra_hash=2c699c71274efd5d40898fa9e380c575" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas -<span class="badge badge-secondary">1/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="https://sei.pe.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=90133&infra_hash=4cdaefc35fd3cdf2b4ef7d38cae7db35" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas -<span class="badge badge-secondary">2/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					@endif
					@if($financialReport == '2022' && $unidade->id == 8)
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage/01 - Janeiro.rar')}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas -<span class="badge badge-secondary">1/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage/01 - Janeiro-Prefeitura.rar')}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas - Prefeitura -<span class="badge badge-secondary">1/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage/HCA 022022 - PREFEITURA.rar')}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas -<span class="badge badge-secondary">2/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage/HCA 022022.rar')}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas - Prefeitura -<span class="badge badge-secondary">2/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage/HCA 032022 - PREFEITURA.rar')}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas -<span class="badge badge-secondary">3/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
						<a href="{{asset('storage/HCA 032022.rar')}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas - Prefeitura -<span class="badge badge-secondary">3/{{$item->ano}}</span> 
						<i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
						</a>
					  </div>
					@endif
					
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
			@if($unidade->id == 9)
			  <div class="list-group" style="font-size: 15px;padding: 2px 2px;">
				<a href="https://sei.pe.gov.br/sei/processo_acesso_externo_consulta.php?id_acesso_externo=90296&infra_hash=85738937d763387a8cc393ff90993e76" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">Prestação de Contas -<span class="badge badge-secondary">2/2022</span> 
			  	 <i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
				</a>
			  </div>
			@endif
			<div class="container" style="margin-top: 15px;">
				<h2 style="font-size: 80px; color:#65b345"><i class="fas fa-file-pdf"></i></h2>
			</div>
			
        </div>
		<div class="col-md-2 col-sm-0"></div>
    </div>
</div>
@endsection