@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">RECURSOS HUMANOS</h3>
		</div>
	</div>
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-1 col-sm-0"></div>
		<div class="col-md-10 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#CEDIDOS" aria-expanded="true" aria-controls="CEDIDOS">
						SERVIDORES PÚBLICOS CEDIDOS <i class="fas fa-sync-alt"></i>
					</a>	
					<div id="CEDIDOS" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
					<div class="card-body" style="background-color: #fafafa">
						<h6 class="text-success"><strong>Não há servidor cedido na unidade</strong></h6>
						<p class="card-text"><small class="text-muted">Última atualização {{date("d/m/Y", strtotime('2019-12-31 00:00:00'))}}</small></p>		
					</div>
					</div>
				</div>
			</div>
        </div>
		<div class="col-md-1 col-sm-0"></div>
    </div>
</div>
@endsection