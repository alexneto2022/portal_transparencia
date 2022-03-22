@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">Despesas Com Pessoal</h3>
		</div>
	</div>
	@if ($errors->any())
			<div class="alert alert-success">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
	@endif
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-1 col-sm-0"></div>
		<div class="col-md-10 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#SELETIVO" aria-expanded="true" aria-controls="SELETIVO">
						DESPESAS COM PESSOAL <i class="fas fa-tasks"></i>
					</a>				
						<form action="{{route('despesasUsuarioRHProcurar', $unidade->id)}}" method="post">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table class="table table-sm">
								<tr>
								<th scope="col" style="margin-left: 40px;"> Mês </th>
								  <td scope="row"> 
									<select style="width: 150px; margin-left: 3px;" class="form-control" id="mes" name="mes" placeholder="Mês">
									 <option value="1" id="mes" name="mes">Janeiro</option>
									 <option value="2" id="mes" name="mes">Fevereiro</option>
									 <option value="3" id="mes" name="mes">Março</option>
									 <option value="4" id="mes" name="mes">Abril</option>
									 <option value="5" id="mes" name="mes">Maio</option>
									 <option value="6" id="mes" name="mes">Junho</option>
									 <option value="7" id="mes" name="mes">Julho</option>
									 <option value="8" id="mes" name="mes">Agosto</option>
									 <option value="9" id="mes" name="mes">Setembro</option>
									 <option value="10" id="mes" name="mes">Outubro</option>
									 <option value="11" id="mes" name="mes">Novembro</option>
									 <option value="12" id="mes" name="mes">Dezembro</option>
									</select>
								  </td>
								  <th scope="col" style="margin-left: -150px;"> Ano </th>
								  <td scope="row"> 
									<select style="width: 90px; padding: 5px; margin-right:px;" class="form-control" id="ano" name="ano" style=>
									  <option value="2017" id="ano" name="ano">2017</option>
									  <option value="2018" id="ano" name="ano">2018</option>
									  <option value="2019" id="ano" name="ano">2019</option>
									  <option value="2020" id="ano" name="ano">2020</option>
									  <option selected value="2021" id="ano" name="ano">2021</option>
									  <option value="2022" id="ano" name="ano">2022</option>
									  <option value="2023" id="ano" name="ano">2023</option>
									  <option value="2024" id="ano" name="ano">2024</option>
									  <option value="2025" id="ano" name="ano">2025</option>
									</select>
								  </td>
								  <th>
								  <th scope="col" style="margin-left: -150px;"> Tipo </th>
								  <td scope="row"> 
									<select style="width: 170px; padding: 5px; margin-right:px;" class="form-control" id="tipo" name="tipo" style=>
									  <option value="base" id="tipo" name="tipo">Salário Base</option>
									  <option value="complemento" id="tipo" name="tipo">Complemento</option>
									  <option value="13" id="tipo" name="tipo">13° Salário</option>
									  <option value="covid" id="tipo" name="tipo">Covid</option>
									</select>
								  </td>
								  <th>
									<td> <input type="submit" class="btn btn-info btn-sm" style="margin-top:;" value="Pesquisar" id="Pesquisar" name="Pesquisar" /> </td>
									<td>
									</td>
								  </th>
								</tr>
							<table>
							</form>

							<table class="table">
							<tr>
								<td>Nível</td>
								<td>Cargo</td>
								<td>Qtd</td>
								<td>Valor</td>
								<td>Tipo</td>
							</tr>
							@if(!empty($despesas))
									@foreach($despesas as $despesa)
									<tr>
										<td style="font-size: 11px; width:128px"><input type="text" id="" name="" readonly="true" class="form-control" value="<?php echo $despesa->Nivel?>" /> </td>
										<td style="font-size: 11px; width:180px"><input type="text" id="" name="" readonly="true" class="form-control" value="<?php echo $despesa->Cargo?>"/> </td>
										<td style="font-size: 11px; width:50px"><input type="text" id="" name="" readonly="true" class="form-control" value="<?php echo $despesa->Quant?>"/></td>
										<td style="font-size: 11px; width:110px"><input type="text" id="" name="" readonly="true" class="form-control" value="<?php echo $despesa->Valor?>"/></td>
										<td style="font-size: 11px; width:80px"><input type="text" id="" name="" readonly="true" class="form-control" value="<?php echo $despesa->tipo?>"/></td>
									</tr>
									@endforeach
							@endif
							</table>
							 <tr>
								<td style="align: right"> 
								   <a href="{{route('transparenciaRecursosHumanos', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
								  @if($ano != null)  
								  @endif 
								</td>
							 </tr>
							</table>
						</form>
			</div>
        </div>
		<div class="col-md-1 col-sm-0"></div>
    </div>
</div>
@endsection