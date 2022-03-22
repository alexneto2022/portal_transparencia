@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR CONTRATAÇÕES:</h3>
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
		<div class="col-md-12 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					  <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Contratos: <i class="fas fa-check-circle"></i>
                    </a>
					<form action="{{\Request::route('storeContratos'), $unidade->id}}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<table border="0" class="table table-sm">
						   <tr>
							  <td> Prestador: </td>
							  <td>
								@if ( !empty($prestadores) )
									<input class="form-control" style="width:100px;" readonly="true" type="hidden" id="id" name="id" value="<?php echo $prestadores[0]->id; ?>">
									<input class="form-control" style="width: 700px;" readonly="true" type="text" id="prestador" name="prestador" value="<?php echo $prestadores[0]->prestador; ?>"> 
								@else 
									<input class="form-control" style="width: 700px;" readonly="true" type="text" id="prestador" name="prestador" value="">
								@endif
							  </td>
							  <td> <a class="btn btn-danger btn-sm" style="" href="{{route('pesquisarPrestador', $unidade->id)}}" > Pesquisar <i class="fas fa-search"></i></a> </td>
							</tr>
							<tr>
						      <td> CNPJ/CPF: </td>
							  <td> 
								@if ( !empty($prestadores) )
									<input class="form-control" style="width: 300px;" readonly="true" type="text" id="cnpj_cpf" name="cnpj_cpf" value="<?php echo $prestadores[0]->cnpj_cpf; ?>"> 
								@else 
									<input class="form-control" style="width: 300px;" readonly="true" type="text" id="cnpj_cpf" name="cnpj_cpf" value="">
								@endif
							  </td>
							</tr>
							<tr>
							 <td> Tipo Contrato: </td>
							 <td> 
								@if ( !empty($prestadores) )
									<input class="form-control" style="width: 300px;" readonly="true" type="text" id="tipo_contrato" name="tipo_contrato" value="<?php echo $prestadores[0]->tipo_contrato; ?>"> 
								@else 
									<input class="form-control" style="width: 300px;" readonly="true" type="text" id="tipo_contrato" name="tipo_contrato" value="">
								@endif
							 </td>		
							</tr>
							<tr>
							 <td> Tipo Pessoa: </td>
							 <td> 
								@if ( !empty($prestadores) )
									<input class="form-control" style="width: 300px;" readonly="true" type="text" id="tipo_pessoa" name="tipo_pessoa" value="<?php echo $prestadores[0]->tipo_pessoa; ?>">	
								@else 
									<input class="form-control" style="width: 300px;" readonly="true" type="text" id="tipo_pessoa" name="tipo_pessoa" value="">
								@endif
							 </td>
						    </tr>
							<tr>
							  <td colspan="5" align="right">
								<a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('prestadorCadastro', $unidade->id)}}" > Novo Prestador <i class="fas fa-check"></i></a>
							 </td>
							</tr>
							<tr>
							  <td> <br /> <br /> </td>
							</tr>
							<input type="hidden" id="prestador_id" name="prestador_id" value="" />
							<tr>
							 <td> Título: </td>
							 <td> <input class="form-control" type="text" id="objeto" name="objeto" value="" required /> </td>
							</tr>
							<tr>
							 <td> Tipo: </td>
							 <td> 
								<select style="width: 150px;" name="aditivos" id="aditivos" style="width: 300px;" class="form-control">	 
							     <option value="0">Contrato</option>
								 <option value="1">Aditivo</option>
								 <option value="2">Distrato</option>
								</select> 
							 </td>
							</tr>
							<tr>
							 <td> Valor: </td>
							 <td> <input style="width: 100px;" class="form-control" type="number" id="valor" name="valor" value="" required /> </td>
							</tr>
							<tr>
							 <td> Início: </td>
							 <td> <input style="width: 200px;" class="form-control" type="date" id="inicio" name="inicio" value="" required /> </td>
							</tr>
							<tr>
							 <td> Fim: </td>
							 <td> <input style="width: 200px;" class="form-control" type="date" id="fim" name="fim" value="" required /> </td>
							</tr>
							<tr>
							 <td> Renovação Automática: </td>
							 <td>  
								<select style="width: 100px;" name="renovacao_automatica" id="renovacao_automatica" class="form-control">	 
							     <option value="0"> Não </option>
								 <option value="1"> Sim </option>
								</select>
							 </td>
							</tr>
							<tr>
							 <td> <input hidden class="form-control" style="width: 200px;" type="number" id="yellow_alert" name="yellow_alert" value="" /> </td>
							</tr>
							<tr>
							 <td> <input hidden class="form-control" style="width: 200px;" type="number" id="red_alert" name="red_alert" value="" /> </td>
							</tr>
							<tr>
							 <td> Arquivo: </td>
							 <td> <input style="width: 400px;" class="form-control" type="file" id="file_path" name="file_path" value="" /> </td>
							</tr>
						</table>	
							
							<table>
							   <tr>
								 <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
								 <td> <input hidden style="width: 100px;" type="text" id="cadastro" name="cadastro" value="1" /></td>
								 <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="contratacao" /> </td>
								 <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarContratacao" /> </td>
								 <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							   </tr>
							</table>
							
						 <table>	
							<input type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
							<tr>
							  <td align="left"> <br /><br /> <a href="{{route('contratacaoCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							  <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> </td>
							</tr>
						</table>
					</form>
				  </div>
				</div>
			  </div> 	
        </div>
    </div>
</div>
@endsection