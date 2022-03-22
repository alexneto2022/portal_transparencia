@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">BENS PÚBLICOS</h3>
		</div>
	</div>
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div class="container text-center">
				<h1 class="text-success"><i class="fas fa-clock"></i></h1>
			</div>
			<h4 style="margin-top: 20px;" class="text-success">Aguardando visita da Secretária de Saúde<h4>
        </div>
		<div class="col-md-2 col-sm-0"></div>
    </div>
</div>
@endsection