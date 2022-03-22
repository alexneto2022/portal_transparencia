@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">DELETAR DESPESAS COM PESSOAL:</h3>
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
						<form action="{{route('updateDespesasRH', array($unidade->id, $ano, $mes, $tipo))}}" method="post">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table class="table table-sm" style="margin-right: 600px;">
								<tr>
								  <td rowspan="" colspan="1"> Mês: </td>
								  <td> 
									<select style="width: 120px" class="form-control" id="mes" name="mes">
									 <option value="<?php $mes ?>" id="mes" name="mes">{{ $mes }}</option>
									</select>
								  </td>
								  <td> Ano: </td>
								  <td> 
									<select style="width:120px;" class="form-control" id="ano" name="ano">
									  <option value="<?php $ano ?>" id="ano" name="ano">{{ $ano }}</option>
									</select>
								  </td>
								  <td> Tipo: </td>
								  <td> 	
									<select style="width:100px;" class="form-control" id="tipo" name="tipo">
									  <option value="<?php $tipo ?>" id="tipo" name="tipo">{{ $tipo }}</option>
									</select>
								  </td>
								</tr>
								<?php $a = 0; ?>
								@if(!empty($despesas))
									@foreach($despesas as $despesa)
									<tr> <?php $a += 1; ?>
										<td style="font-size: 11px; width:175px"><input type="text" id="id_<?php echo $a; ?>" name="id_<?php echo $a;?>" readonly = "true" class="form-control" value="<?php echo $despesa->id?>" /> </td>
										<td style="font-size: 11px; width:175px"><input type="text" id="" name="" readonly = "true" class="form-control" value="<?php echo $despesa->Nivel?>" /> </td>
										<td style="font-size: 11px; width:160px"><input type="text" id="" name="" readonly = "true" class="form-control" value="<?php echo $despesa->Cargo?>"/> </td>
										<td style="font-size: 11px; width:70px"><input type="text" id="quant_<?php echo $a; ?>" name="quant_<?php echo $a;?>"  class="form-control" value="<?php echo $despesa->Quant?>"/></td>
										<td style="font-size: 11px; width:130px"><input type="text" id="valor_<?php echo $a; ?> " name="valor_<?php echo $a?>" class="form-control" value="<?php echo $despesa->Valor?>"/></td>

									</tr>
									@endforeach
								  @endif
							 <tr>
								<td style="align: right"> 
								   <a href="{{route('despesasRH', array($unidade->id))}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
								   <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> 
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