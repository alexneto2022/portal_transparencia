@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">RELATÓRIO MENSAL DE EXECUÇÃO</h3>
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
						<p style="color:#28a745;">Produção Ambulatorial de Procedimentos da Tabela Unificada</p>
						<p style="color:#28a745;">Frequência por procedimento e mês competencia</p>
						<p style="color:#28a745;">Estabel-CNES PE: 0000582 HOSPITAL DE CANCER DE PERNAMBUCO</p>
						<p style="color:#28a745;">Período:Jan-Abr/2018</p>
					<br/>
					<table>
					 <tr>
						<td> <a href="" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Relatório Hospitalar - 2018 </a>  </td>
						<td> <a href="" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Relatório Ambulatorial - 2018 </a> </td>
					</tr>
					</table>
				</div>
			@endif	
			</div>
		</div>
		<div class="col-md-2 col-sm-0"></div>
	</div>
</div>
@endsection