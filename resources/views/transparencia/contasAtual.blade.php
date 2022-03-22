@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">RELATÓRIO CONTAS ATUAL</h3>
		</div>
	</div>
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
							      <!--a href="{{route('covenioCadastro', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a></p-->
							    @endif
							</h5>
					</div>
					<br/><strong>Em Desenvolvimento...</strong>
					<!--div id="1" class="collapse {{$unidade->id == 1? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordion">
						<div class="card-body"  style="font-size: 14px;">
						</div>
					</div-->
				</div>
			@endif	
			</div>
		</div>
		<div class="col-md-2 col-sm-0"></div>
	</div>
</div>
@endsection