@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">EXCLUIR OUVIDORIA:</h3>
		</div>
	</div>

	@if (Session::has('mensagem'))
		@if ($text == true)
		<div class="container">
	     <div class="alert alert-danger {{ Session::get ('mensagem')['class'] }} ">
	      {{ Session::get ('mensagem')['msg'] }}
		 </div>
		</div>
		@endif
	@endif
	
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div id="accordion">
				<div class="card ">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Ouvidoria: <i class="fas fa-check-circle"></i>
                    </a>
						<div class="card-body"  style="font-size: 14px;">
						<form action="{{\Request::route('destroyOuvidoria'), $unidade->id}}" method="post">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table>
								<tr>
								 <td> <strong> Unidade: </strong> </td>
								 <td> <select class="form-control" id="unidade_id" name="unidade_id" readonly="true">
								        @if($ouvidoria->unidade_id == 1)
										<option id="unidade_id" name="unidade_id" value="1"> HCP GESTÃO </option>
										@elseif($ouvidoria->unidade_id == 2)
										<option id="unidade_id" name="unidade_id" value="2"> HOSPITAL DA MULHER DO RECIFE </option>
										@elseif($ouvidoria->unidade_id == 3)
										<option id="unidade_id" name="unidade_id" value="3"> UPAE BELO JARDIM </option>
										@elseif($ouvidoria->unidade_id == 4)
										<option id="unidade_id" name="unidade_id" value="4"> UPAE ARCOVERDE </option>
										@elseif($ouvidoria->unidade_id == 5)
										<option id="unidade_id" name="unidade_id" value="5"> UPAE ARRUDA </option>
										@elseif($ouvidoria->unidade_id == 6)
										<option id="unidade_id" name="unidade_id" value="6"> UPAE CARUARU </option>
										@elseif($ouvidoria->unidade_id == 7)
										<option id="unidade_id" name="unidade_id" value="7"> HOSPITAL SÃO SEBASTIÃO </option>
										@elseif($ouvidoria->unidade_id == 8)
										<option id="unidade_id" name="unidade_id" value="8"> HOSPITAL PROVISÓRIO DO RECIFE 1 </option>
										@endif
									  </select>
								 </td>
								</tr>
							    <tr>
								 <td> <strong>Responsável:</strong> </td>
								 <td> <input style="" class="form-control" type="text" id="responsavel" name="responsavel" value="<?php echo $ouvidoria->responsavel; ?>" /> </td> 
								</tr> 
								<tr>
								 <td> <strong> E-mail: </strong> </td>
								 <td> <input style="width: 400px;" class="form-control" type="text" id="email" name="email" required value="<?php echo $ouvidoria->email; ?>" /> </td>
								</tr>
								<tr>
								 <td> <strong> Telefone: </strong> </td>
								 <td> <input style="width: 400px" class="form-control" type="text" id="telefone" name="telefone" required value="<?php echo $ouvidoria->telefone; ?>" /> </td> 
								</tr>
							</table>
							<table>
							  <tr>     
							    <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
								<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="Covenio" /> </td>
								<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="ExcluirCovenio" /> </td>
								<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							  </tr>
							</table>
							
							<table>
								<tr>
								  <td align="left"> <br />
									<p><h6 align="left"> Deseja realmente Excluir esta Ouvidoria?? </h6></p>
									<a href="{{route('sicCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
									<input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir" id="Excluir" name="Excluir" />
								  </td>
								</tr>
							</table>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-2 col-sm-0"></div>
		<br /> <br />	
	</div>
</div>
@endsection