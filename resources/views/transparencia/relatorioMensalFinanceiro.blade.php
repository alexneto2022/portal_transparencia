@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">RELATÓRIO MENSAL FINANCEIRO DO ATUAL EXERCÍCIO</h3>
		</div>
	</div>
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-12 col-sm-12 text-center">
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
					 <br /><br />
					 <p style="color: #28a745">Valor AMBULATORIAL aprovado. CNES: 000582. Período: Jan-Abr/2018</p>
					 <table class="table table-sm ">
						<thead class="bg-success">
							<tr>
								<th scope="col">Estabel-CNES PE</th>
								<th scope="col">Jan</th>
								<th scope="col">Fev</th>
								<th scope="col">Abr</th>
								<th scope="col">Mar</th>
								<th scope="col">Total</th>
								<th scope="col">Média Mensal</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="font-size: 14px;">0000582 HOSPITAL DE CANCER DE PERNAMBUCO</td>
								<td style="font-size: 14px;">3.087.325,37</td>
								<td style="font-size: 14px;">2.892.839,55</td>
								<td style="font-size: 14px;">3.120.491,17</td>
								<td style="font-size: 14px;">3.606.808,27</td>
								<td style="font-size: 14px;">12.707.464,36</td>
								<td style="font-size: 14px;">3.176.866,09</td>
							</tr>
						</tbody>
					</table>
					<br /><br />
					<p style="color: #28a745">Valor HOSPITALAR aprovado. CNES: 000582. Período: Jan-Abr/2018</p>
					 <table class="table table-sm ">
						<thead class="bg-success">
							<tr>
								<th scope="col">Estabel-CNES PE</th>
								<th scope="col">Jan</th>
								<th scope="col">Fev</th>
								<th scope="col">Abr</th>
								<th scope="col">Mar</th>
								<th scope="col">Total</th>
								<th scope="col">Média Mensal</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="font-size: 14px;">0000582 HOSPITAL DE CANCER DE PERNAMBUCO</td>
								<td style="font-size: 14px;">2.867.827,24</td>
								<td style="font-size: 14px;">2.512.719,78</td>
								<td style="font-size: 14px;">3.176.748,13</td>
								<td style="font-size: 14px;">3.103.213,60</td>
								<td style="font-size: 14px;">11.660.508,75</td>
								<td style="font-size: 14px;">2.915.127,19</td>
							</tr>
						</tbody>
					</table>



				</div>
			@endif	
			</div>
		</div>
		<div class="col-md-2 col-sm-0"></div>
	</div>
</div>
@endsection