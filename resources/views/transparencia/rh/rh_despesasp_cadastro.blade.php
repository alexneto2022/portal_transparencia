@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR DESPESAS COM PESSOAL:</h3>
		</div>
	</div>
	@if ($errors->any())
			<div class="alert alert-danger">
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
						<form action="{{\Request::route('storeDespesas'), $unidade->id}}" method="post">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table class="table table-sm" style="margin-right: 400px;">
								<tr>
								  <td rowspan="" colspan="1"> Mês: </td>
								  <td> 
									<select style="width: 140px" class="form-control" id="mes" name="mes">
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
								  <td> Ano: </td>
								  <td> 
									<select style="width:100px;" class="form-control" id="ano" name="ano">
									  <option value="2010" id="ano" name="ano">2010</option>
									  <option value="2011" id="ano" name="ano">2011</option>
									  <option value="2012" id="ano" name="ano">2012</option>
									  <option value="2013" id="ano" name="ano">2013</option>
									  <option value="2014" id="ano" name="ano">2014</option>
									  <option value="2015" id="ano" name="ano">2015</option>
									  <option value="2016" id="ano" name="ano">2016</option>
									  <option value="2017" id="ano" name="ano">2017</option>
									  <option value="2018" id="ano" name="ano">2018</option>
									  <option value="2019" id="ano" name="ano">2019</option>
									  <option value="2020" id="ano" name="ano">2020</option>
									  <option selected value="2021" id="ano" name="ano">2021</option>
									  <option value="2022" id="ano" name="ano">2022</option>
									  <option value="2023" id="ano" name="ano">2023</option>
									  <option value="2024" id="ano" name="ano">2024</option>
									</select>
								  </td>
								  <td> Tipo: </td>
								  <td> 	
									  <select style="width:180px;" class="form-control" id="tipo" name="tipo">
									  <option value="base" id="tipo" name="tipo">Salário Base</option>
									  <option value="complemento" id="tipo" name="tipo">Complemento</option>
									  <option value="13" id="tipo" name="tipo">13° Salário</option>
									  <option value="covid" id="tipo" name="tipo">Covid</option>
								</td>
								</tr>
							</table>
							<table>
								<tr style="margin-right: 90px;">
								  <td> Nível: </td>
								  <td> Cargos: </td>
								  <td> Qtd: </td>	
								  <td> Valores (R$): </td>
								</tr>
							    <tr>
								  <td rowspan="4"> <input class="form-control" readonly="true" style="width: 250px;" type="text" id="nivel1" name="nivel1" value="SUPERIOR" required /> </td>					 
								  <td> <input class="form-control" readonly="true" style="width: 250px;" type="text" name="cargo1" id="cargo1" required value="MEDICOS" /> </td>
								  <td> <input class="form-control" style="width: 100px;" type="number" id="Quant1" name="Quant1" value="<?php echo old('Quant1') ?>" required /> </td>
								  <td> <input class="form-control" style="width: 150px;" type="text" id="valor1" name="valor1" value="<?php echo old('valor1') ?>" required /> </td>
								</tr>
								<tr>
								  <td> <input class="form-control" readonly="true" style="width: 250px;" type="text" name="cargo2" id="cargo2" required value="ENFERMEIROS" /> </td>
								  <td> <input class="form-control" style="width: 100px;" type="number" id="Quant2" name="Quant2" value="<?php echo old('Quant2') ?>" required /> </td>
								  <td> <input class="form-control" style="width: 150px;" type="text" id="valor2" name="valor2" value="<?php echo old('valor2') ?>" required /> </td>
								</tr>
								<tr>
								  <td> <input class="form-control" readonly="true" style="width: 250px;" type="text" name="cargo3" id="cargo3" required value="OUTROS NIVEL SUPERIOR" /> </td>	
								  <td> <input class="form-control" style="width: 100px;" type="number" id="Quant3" name="Quant3" value="<?php echo old('Quant3') ?>" required /> </td>
								  <td> <input class="form-control" style="width: 150px;" type="text" id="valor3" name="valor3" value="<?php echo old('valor3') ?>" required /> </td>
								</tr>
								<tr>
								  <td> <input class="form-control" readonly="true" style="width: 250px;" type="text" name="cargo4" id="cargo4" required value="TOTAL" /> </td>
								  <td> <input class="form-control" style="width: 100px;" type="number" id="Quant4" name="Quant4" value="<?php echo old('Quant4') ?>" required /> </td>
								  <td> <input class="form-control" style="width: 150px;" type="text" id="valor4" name="valor4" value="<?php echo old('valor4') ?>" required /> </td>
								</tr>
								<tr>  
								  <td rowspan="4"> <input class="form-control" readonly="true" style="width: 250px;" type="text" id="nivel2" name="nivel2" value="TECNICO/MEDIO" required /> </td>
								</tr>
								<tr>
								  <td> <input class="form-control" readonly="true" style="width: 250px;" type="text" name="cargo5" id="cargo5" required value="TEC. ENFERMAGEM" /> </td>
								  <td> <input class="form-control" style="width: 100px;" type="number" id="Quant5" name="Quant5" value="<?php echo old('Quant5') ?>" required /> </td>
								  <td> <input class="form-control" style="width: 150px;" type="text" id="valor5" name="valor5" value="<?php echo old('valor5') ?>" required /> </td>
								</tr>
								<tr>
								  <td> <input class="form-control" readonly="true" style="width: 250px;" type="text" name="cargo6" id="cargo6" required value="OUTROS TECNICOS/MEDIO" /> </td>
								  <td> <input class="form-control" style="width: 100px;" type="number" id="Quant6" name="Quant6" value="<?php echo old('Quant6') ?>" required /> </td>
								  <td> <input class="form-control" style="width: 150px;" type="text" id="valor6" name="valor6" value="<?php echo old('valor6') ?>" required /> </td>
								</tr>
								<tr>
								  <td> <input class="form-control" readonly="true" style="width: 250px;" type="text" name="cargo7" id="cargo7" required value="TOTAL" /> </td>
								  <td> <input class="form-control" style="width: 100px;" type="number" id="Quant7" name="Quant7" value="<?php echo old('Quant7') ?>" required /> </td>
								  <td> <input class="form-control" style="width: 150px;" type="text" id="valor7" name="valor7" value="<?php echo old('valor7') ?>" required /> </td>
								</tr>
								<tr>  
								  <td rowspan="3"> <input class="form-control" readonly="true" style="width: 250px;" type="text" id="nivel3" name="nivel3" value="ELEMENTAR" required /> </td>
								</tr>
								<tr>
								  <td> <input class="form-control" readonly="true" style="width: 250px;" type="text" name="cargo8" id="cargo8" required value="APOIO ELEMENTAR" /> </td>
								  <td> <input class="form-control" style="width: 100px;" type="number" id="Quant8" name="Quant8" value="<?php echo old('Quant8') ?>" required /> </td>
								  <td> <input class="form-control" style="width: 150px;" type="text" id="valor8" name="valor8" value="<?php echo old('valor8') ?>" required /> </td>
								</tr>
								<tr>
								  <td> <input class="form-control" readonly="true" style="width: 250px;" type="text" name="cargo9" id="cargo9" required value="TOTAL" /> </td>
								  <td> <input class="form-control" style="width: 100px;" type="number" id="Quant9" name="Quant9" value="<?php echo old('Quant9') ?>" required /> </td>
								  <td> <input class="form-control" style="width: 150px;" type="text" id="valor9" name="valor9" value="<?php echo old('valor9') ?>" required /> </td>
								</tr>
								<tr>  
								  <td rowspan="1" colspan="2"> <input class="form-control" readonly="true" style="width: 500spx;" type="text" id="nivel4" name="nivel4" value="TOTAL GERAL" required /> </td>
								  <td rowspan="1" colspan="1"> <input class="form-control" style="width: 100px;" type="number" id="Quant10" name="Quant10" value="<?php echo old('Quant10') ?>" required /> </td>
								  <td rowspan="2" colspan="5"> <input class="form-control" style="width: 150px;" type="text" id="valor10" name="valor10" value="<?php echo old('valor10') ?>" required /> </td>
								</tr>
							</table>							
							<table>
							 <tr>
								<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
    							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="despesasPessoais" /> </td>
							    <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarDespesasPessoais" /> </td>
							    <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							 </tr>
							</table>	
							<table>
							 <tr>
								<td>
								  <p style="margin-left: 610px;;"> 
								   <a href="{{route('despesasRH', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
								   <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> 
								  </p>
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