@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">EXCLUIR DESPESAS COM PESSOAL:</h3>
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
						<form action="{{route('destroyDespesasRH', array($unidade->id, $ano, $mes, $tipo))}}" method="post">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table class="table table-sm" style="margin-right: 400px;">
								<tr>
								  <td> Mês: </td> 
								  <td> 
									<select style="width: 70px;" class="form-control" id="mes" name="mes">
									  <option value="<?php echo $mes ?>" id="mes" name="mes">{{ $mes }}</option>
									</select>
								  </td>	
								  <td>  Ano: </td>
								  <td>	
									<select style="width:100px;" class="form-control" id="ano" name="ano">
									  <option value="<?php echo $ano ?>" id="ano" name="ano">{{ $ano }}</option>
									</select>
								  </td>	
								  <td> Tipo: </td>
								  <td> 
								    <select style="width:160px;" class="form-control" id="tipo" name="tipo">
									  <option value="<?php echo $tipo ?>" id="tipo" name="tipo">{{ $tipo }}</option>
									</select>
								  </td>
								</tr>
							  </table>
							  <table> 
								<tr>
								  <td><br>Nível</td>
								  <td><br>Cargo</td>
								  <td><br>Qtd</td>
								  <td><br>Valor</td>
								</tr>
								<?php $a = 0; ?>
								@if(!empty($despesas))
									@foreach($despesas as $despesa)
									<tr> <?php $a += 1; ?>
										<td hidden style="font-size: 11px; width:190px"><input type="text" id="id_<?php echo $a; ?>" name="id_<?php echo $a;?>" readonly="true" class="form-control" value="<?php echo $despesa->id?>" /> </td>
										<td style="font-size: 11px; width:350px"><input type="text" id="nivel" name="nivel" readonly="true" class="form-control" value="<?php echo $despesa->Nivel?>" /> </td>
										<td style="font-size: 11px; width:500px"><input type="text" id="cargo" name="cargo" readonly="true" class="form-control" value="<?php echo $despesa->Cargo?>"/> </td>
										<td style="font-size: 11px; width:120px"><input type="text" id="quant_<?php echo $a; ?>" name="quant_<?php echo $a;?>"  class="form-control" readonly="true" value="<?php echo $despesa->Quant?>"/></td>
										<td style="font-size: 11px; width:220px"><input type="text" id="valor_<?php echo $a; ?> " name="valor_<?php echo $a?>" class="form-control" readonly="true" value="<?php echo $despesa->Valor?>"/></td>
									</tr>
									@endforeach
								@endif
								
							</table>
							<table>	  
							 <tr>
								  <td><br> <b> Deseja Realmente Excluir esta Despesa Pessoal? </b> </td>
							 </tr>  
							 <tr>
								<td>
								  <p style="margin-left: 700px;"> 	  
								   <a href="{{route('despesasRH', array($unidade->id))}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
								   <input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir" id="Salvar" name="Salvar" /> 
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