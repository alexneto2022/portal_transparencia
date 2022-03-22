@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">RESULTADOS DOS PROCESSOS DE COTAÇÃO DE PREÇO</h3>
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
							</h5>
					</div>
					<br/>
						<p style="color:green;"><strong>Link para o Portal SINTESE - <a target="_blank" href="https://plataformasintese.com/PortalTransparencia.aspx?cnpj=10894988000133"> clique aqui </a></strong></p>
					<br/>
					</div>
			@endif	
			</div>
		</div>
		<div class="col-md-2 col-sm-0"></div>
	</div>
</div>
@endsection