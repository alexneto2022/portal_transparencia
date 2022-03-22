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
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#REGULAMENTO" aria-expanded="true" aria-controls="REGULAMENTO">
					REGULAMENTO <i class="fas fa-book"></i>
					</a>
					<div id="REGULAMENTO" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
					<div class="card-body" style="font-size: 15px;background-color: #fafafa;">
						<i style="margin-right: 5px;" class="fas fa-scroll"></i>Manual de Normas e Procedimentos da Área de Desenvolvimento Humano<a style="margin-left:10px;" class="btn btn-success btn-sm" href="{{asset('storage/')}}/Manual_DH_do_HCP.pdf" role="button">Download<i style="margin-left:5px;" class="fas fa-download"></i></a>
					
						<p class="card-text"><small class="text-muted">Última atualização {{date("d/m/Y", strtotime($lastUpdatedRegulamento))}}</small></p>

					</div>
					</div>
				</div>
			</div>
        </div>
		<div class="col-md-1 col-sm-0"></div>
    </div>
</div>
@endsection