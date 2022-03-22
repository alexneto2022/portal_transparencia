@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">EXCLUIR RELATÓRIO MENSAL DE EXECUÇÃO:</h3>
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
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div id="accordion">
				<div class="card ">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Relatório Mensal de Execução: <i class="fas fa-check-circle"></i>
                    </a>
						<div class="card-body"  style="font-size: 14px;">
							<form action="{{\Request::route('store'), $unidade->id}}" method="post" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table>
							    <tr>
								 <td> <strong>Título:</strong> </td>
								 <td> <input style="" class="form-control" type="text" id="title" name="title" readonly="true" value="<?php echo $demonstrativoContaveis[0]->title; ?>" required /> </td> 
								</tr>
								<tr> <td> &nbsp; </td> </tr>
								<tr>
								 <td> <strong>Mês:</strong> </td>
								 <td>
									<input type="text" readonly="true" class="form-control" style="width: 200px" id="mes" name="mes" value="<?php echo $demonstrativoContaveis[0]->mes; ?>">
								 </td>
								</tr> 
								<tr> <td> &nbsp; </td> </tr>
								<tr>
								 <td> <strong>Ano:</strong> </td>
								 <td> <input style="width: 100px;" class="form-control" type="text" maxlength="4" id="ano" name="ano" value="<?php echo $demonstrativoContaveis[0]->ano; ?>" readonly="true" required /> </td> 
								</tr> 
								<tr>
								 <td> <br/> <strong> Arquivo: </strong> </td>
								 <td> <br/> <input style="width: 500px;" class="form-control" type="text" id="file_path" name="file_path" readonly="true" value="<?php echo $demonstrativoContaveis[0]->file_path; ?>" /> </td>
								</tr>
							</table>
							
							<table>
							  <tr>     
							    <td> <input hidden type="text" class="form-control" id="validar" name="validar" value="1"> </td>
							    <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
								<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="RelatorioGerencial" /> </td>
								<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarRelatorioGerencial" /> </td>
								<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							  </tr>
							</table>
							
							<table>
							 <tr>
							  <td align="left">
							    <br> <p><h6 align="left"> Deseja realmente Excluir este Relatório Mensal de Execução?? </h6></p> <br>
							    <a href="{{route('cadastroRelGerencial', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							    <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Excluir" id="Salvar" name="Salvar" />
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