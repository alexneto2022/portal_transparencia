@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">MEMBROS DIRIGENTES</h5>
		</div>
	</div>	
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 col-sm-12">


			<div class="accordion" id="accordionExample">
				<div class="card">
					<div class="card-header d-flex justify-content-between" id="headingOne">
						<h5 class="mb-0">
							<a class="btn btn-link text-dark no-underline" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								ASSOCIADOS <i class="far fa-list-alt"></i>
							</a>
						</h5>
						<h5 class="mb-0">
							<a href="{{route('exportAssociados')}}" class="btn btn-success btn-sm"><i class="fas fa-file-csv" style="margin-right: 5px;"></i>Download</a>
							@if(Auth::check())
							 @foreach ($permissao_users as $permissao)
							  @if(($permissao->permissao_id == 13) && ($permissao->user_id == Auth::user()->id))
							   @if ($permissao->unidade_id == $unidade->id)
								 <a class="btn btn-info btn-sm" href="{{route('listarAssociado', $unidade->id)}}" >Alterar <i class="fas fa-edit"></i></a>
							   @endif	
							  @endif 
							 @endforeach 
							@endif
						</h5>
					</div>
					
					<div id="collapseOne" class="collapse {{$escolha == 'Associados'? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordionExample">
					    
						<div class="card-body">
							<div class="container text-center"><h5 style="font-size: 15px;"><strong>Estrutura Organizacional do Hospital de Câncer de Pernambuco - Associados Efetivos</strong></h5></div>
							<div class="row">
								<div class="col-md-2 col-sm-0"></div>
								<div class="col-md-8 col-sm-12">
									<table class="table table-sm">
										<thead >
											<tr class="text-center">
												<th class="border-bottom" scope="col">Nome</th>
												<th class="border-bottom" scope="col">CPF</th>
											</tr>
										</thead>
										<tbody class=""> 
											@foreach($associados as $associado)
												@csrf
												<tr>
													<td style="font-size: 12px;" id="valorName">{{$associado->name}} </td>
													<td class="text-center" style="font-size: 12px;" id="valorCpf">{{$associado->cpf}} </td>
												</tr>
											</form>
											@endforeach
											
										</tbody>
									</table>
								</div>
								<div class="col-md-2 col-sm-0"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header d-flex justify-content-between" id="headingOne">
						<h5 class="mb-0">
							<a class="btn btn-link text-dark no-underline" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
								CONSELHO DE ADMINISTRAÇÃO <i class="far fa-list-alt"></i>
							</a>
						</h5>
						<h5 class="mb-0">
							<a href="{{route('exportConselhoAdm')}}" class="btn btn-success btn-sm"><i class="fas fa-file-csv" style="margin-right: 5px;"></i>Download</a>
							@if(Auth::check())	
							 @foreach ($permissao_users as $permissao)
							  @if(($permissao->permissao_id == 13) && ($permissao->user_id == Auth::user()->id))
							   @if ($permissao->unidade_id == $unidade->id)
								<a class="btn btn-info btn-sm" href="{{route('listarConselhoAdm', $unidade->id)}}" >Alterar <i class="fas fa-edit"></i></a>
							   @endif
							  @endif 
							 @endforeach 
							@endif
						</h5>
					</div>
					<div id="collapseTwo" class="collapse {{$escolha == 'Conselho administrativo'? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body">
							<div class="container text-center"><h5 style="font-size: 15px;"><strong>Estrutura Organizacional do Hospital de Câncer de Pernambuco - Conselho de Administração</strong></h5></div>
							<div class="row">
								<div class="col-md-2  col-sm-0"></div>
								<div class="col-md-8  col-sm-12">
									<table class="table table-sm">
										<thead >
											<tr class="text-center">
												<th class="border-bottom" scope="col">Nome</th>
												<th class="border-bottom" scope="col">Cargo</th>
											</tr>
										</thead>
										@foreach($conselhoAdms as $conselhoAdm)
										<tbody class="">
											<tr>
												<td style="font-size: 12px;">{{$conselhoAdm->name}}</td>
												<td style="font-size: 12px;">{{$conselhoAdm->cargo}}</td>
											</tr>
										</tbody>
										@endforeach	
									</table>
								</div>
								<div class="col-md-2  col-sm-0"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header d-flex justify-content-between" id="headingOne">
						<h5 class="mb-0">
							<a class="btn btn-link text-dark no-underline" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
								CONSELHO FISCAL <i class="far fa-list-alt"></i>
							</a>
						</h5>
						<h5 class="mb-0">
							<a href="{{route('exportConselhoFisc')}}" class="btn btn-success btn-sm"><i class="fas fa-file-csv" style="margin-right: 5px;"></i>Download</a>
							@if(Auth::check())	
							 @foreach ($permissao_users as $permissao)
							  @if(($permissao->permissao_id == 13) && ($permissao->user_id == Auth::user()->id))
							   @if ($permissao->unidade_id == $unidade->id)
								<a class="btn btn-info btn-sm" href="{{route('listarConselhoFisc', $unidade->id)}}" >Alterar <i class="fas fa-edit"></i></a>
							   @endif
							  @endif 
							 @endforeach 
							@endif
						</h5>						
					</div>
					<div id="collapseThree" class="collapse {{$escolha == 'Conselho fiscal'? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body">
							<div class="container text-center"><h5 style="font-size: 15px;"><strong>Estrutura Organizacional do Hospital de Câncer de Pernambuco - Conselho Fiscal</strong></h5></div>
							<div class="row">
								<div class="col-md-2 col-sm-0"></div>
								<div class="col-md-8 col-sm-12">
									<table class="table table-sm">
										<tbody class="text-center">
											<tr>
												<td colspan="3" class="text-left border-0" style="font-size: 12px;"><strong>Titulares</strong></td>
											</tr>
											@foreach($conselhoFiscs as $conselhoFisc)
											@if($conselhoFisc->level === 'Titular')

											<tr>
												<td style="font-size: 12px;" id="valorTitulares">{{$conselhoFisc->name}}</td>
												<td id="td5" hidden> <input type="text" id="txtTitulares" name="txtTitulares" value="<?php echo $conselhoFisc->name; ?>" /> </td> 
											</tr>
											@endif
											@endforeach
											<tr>
												<td colspan="3" class="text-left border-0" style="font-size: 12px;"><strong>Suplentes</strong></td>
											</tr>
											@foreach($conselhoFiscs as $conselhoFisc)
											@if($conselhoFisc->level === 'Suplente')

											<tr>
												<td style="font-size: 12px;" id="valorSuplentes">{{$conselhoFisc->name}}</td>
											</tr>
											@endif
											@endforeach
										</tbody>
									</table>
								</div>
								<div class="col-md-2 col-sm-0"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header d-flex justify-content-between" id="headingOne">
						<h5 class="mb-0">
							<a class="btn btn-link text-dark no-underline" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
								SUPERINTENDENTES <i class="far fa-list-alt"></i>
							</a>
						</h5>
						<h5 class="mb-0">
							<a href="{{route('exportSuperintendente')}}" class="btn btn-success btn-sm"><i class="fas fa-file-csv" style="margin-right: 5px;"></i>Download</a>
							@if(Auth::check())
							 @foreach ($permissao_users as $permissao)
							  @if(($permissao->permissao_id == 13) && ($permissao->user_id == Auth::user()->id))
							   @if ($permissao->unidade_id == 1)
								<a class="btn btn-info btn-sm" href="{{route('listarSuper', $unidade->id)}}" >Alterar <i class="fas fa-edit"></i></a>
							   @endif
							  @endif
							 @endforeach		
							@endif
						</h5>
					</div>
					<div id="collapseFour" class="collapse {{$escolha == 'Superintendentes'? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body">
							<div class="container text-center"><h5 style="font-size: 15px;"><strong>Estrutura Organizacional do Hospital de Câncer de Pernambuco - Superintendentes</strong></h5></div>
							<div class="row">
								<div class="col-md-2 col-sm-0"></div>
								<div class="col-md-8 col-sm-12">
									<table class="table table-sm">
										<thead >
											<tr class="row text-center">
												<th class="border-bottom col-md-4" scope="col">Nome</th>
												<th class="border-bottom col-md-8" scope="col">Cargo</th>
											</tr>
										</thead>
										<tbody class="text-center">

											@foreach($superintendentes as $superintendente)

											<tr class='row'>
												<td class="col-md-4 align-middle" style="font-size: 12px;">{{$superintendente->name}}</td>
												<td class="text-left col-md-8" style="font-size: 12px;">{{$superintendente->cargo}}</td>
											</tr>

											@endforeach
										</tbody>
									</table>
								</div>
								<div class="col-md-2 col-sm-0"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection