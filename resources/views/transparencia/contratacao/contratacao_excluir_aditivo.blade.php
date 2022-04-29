@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			@if($aditivos[0]->opcao == 0)
			<h3 style="font-size: 18px;">EXCLUIR CONTRATO:</h3>
			@elseif($aditivos[0]->opcao == 1)
			<h3 style="font-size: 18px;">EXCLUIR ADITIVO:</h3>
			@else
			<h3 style="font-size: 18px;">EXCLUIR DISTRATO:</h3>
			@endif
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
					<div class="card-header" id="headingThree">
						<h2 class="mb-0">
							<a class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								@if($aditivos[0]->opcao == 0)
								<strong>Contrato</strong>
								@elseif($aditivos[0]->opcao == 1)
								<strong>Aditivo</strong>
								@else
								<strong>Distrato</strong>
								@endif
							</a>
						</h2>
					</div>
					<form action="{{\Request::route('destroyAditivo'), $unidade->id, $aditivos[0]->id}}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<table border="0" class="table table-sm">
							<tr>
								<td> ID Prestador: </td>
								<td> <input class="form-control" style="width: 90px;" readonly="true" type="text" id="prestador_id" name="prestador_id" value="<?php echo $prestadores[0]->id; ?>"> </td>
							</tr>
							<tr>
								<td> Prestador: </td>
								<td> <input class="form-control" style="width: 500px;" readonly="true" type="text" id="prestador" name="prestador" value="<?php echo $prestadores[0]->prestador; ?>">
							</tr>
							<tr>
								<td> <br /> <br /> </td>
							</tr>
							<tr>
								<td> ID do 1º Contrato: </td>
								<td> <input class="form-control" style="width: 90px;" readonly="true" type="text" id="id" name="id" value="<?php echo $contratos[0]->id; ?>" /> </td>
								</td>
							<tr>
								@if($aditivos[0]->opcao == 0)
								<td>ID do contrato a excluir:</td>
								@elseif($aditivos[0]->opcao == 1)
								<td>ID do Aditivo a excluir:</td>
								@else
								<td>ID do Distrato a excluir:</td>
								@endif
								<td> <input style="width: 90px;" readonly="true" class="form-control" type="text" id="file_path" name="file_path" value="<?php echo $aditivos[0]->id; ?>" /> </td>
							</tr>
							<tr>
								<td> Título: </td>
								<td> <input class="form-control" style="width: 500px;" readonly="true" type="text" id="objeto" name="objeto" value="<?php echo $contratos[0]->objeto; ?>" /> </td>
							</tr>
							<tr>
							</tr>
							<tr>
								<td> Valor: </td>
								<td> <input style="width: 100px;" readonly="true" class="form-control" type="number" id="valor" name="valor" value="<?php echo $aditivos[0]->valor; ?>" /> </td>
							</tr>
							<tr>
								<td> Início: </td>
								<td> <input style="width: 200px;" readonly="true" class="form-control" type="date" id="inicio" name="inicio" value="<?php echo $aditivos[0]->inicio; ?>" /> </td>
							</tr>
							<tr>
								<td> Fim: </td>
								<td> <input style="width: 200px;" readonly="true" class="form-control" type="date" id="fim" name="fim" value="<?php echo $aditivos[0]->fim; ?>" /> </td>
							</tr>
							<tr>
								<td> Renovação Automática: </td>
								<td>
									<select style="width: 100px;" readonly="true" name="renovacao_automatica" id="renovacao_automatica" class="form-control">
										<option value="<?php $aditivos[0]->renovacao_automatica; ?>"> <?php if ($aditivos[0]->renovacao_automatica === 1) { ?> SIM <?php } else { ?> NÃO <?php } ?> </option>
									</select>
								</td>
							</tr>
							<tr hidden>
								<td> Yellow Alert: </td>
								<td> <input class="form-control" readonly="true" style="width: 200px;" type="number" id="yellow_alert" name="yellow_alert" value="<?php echo $contratos[0]->yellow_alert; ?>" /> </td>
							</tr>
							<tr hidden>
								<td> Red Alert: </td>
								<td> <input class="form-control" readonly="true" style="width: 200px;" type="number" id="red_alert" name="red_alert" value="<?php echo $contratos[0]->red_alert; ?>" /> </td>
							</tr>
							<tr>
								<td> Arquivo: </td>
								<td> <input style="width: 500px;" readonly="true" class="form-control" type="text" id="file_path" name="file_path" title="{{$contratos[0]->file_path}}" value="<?php echo $aditivos[0]->file_path; ?>" /> </td>
							</tr>
							<tr>
								<td> <br /> <br /> </td>
							</tr>
						</table>
						<table>
							<tr>
								<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
								<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="contratacao" /> </td>
								<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="excluirContratacao" /> </td>
								<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							</tr>
						</table>
						<table>
							<tr>
								<td align="left"><br /><br />
									<?php $tipoArq = ""; ?>
									@if($aditivos[0]->opcao == 0)
									<h6 align="left"> Deseja realmente Excluir este Contrato?? </h6>
									<?php $tipoArq = "Contrato"; ?>
									@elseif($aditivos[0]->opcao == 1)
									<h6 align="left"> Deseja realmente Excluir este Aditivo?? </h6>
									<?php $tipoArq = "Aditivo"; ?>
									@else
									<h6 align="left"> Deseja realmente Excluir este Distrato?? </h6>
									<?php $tipoArq = "Distrato"; ?>
									@endif

								</td>
							</tr>
							<tr>
								<td align="left"><a href="javascript:history.back();" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
									<input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir <?php echo $tipoArq; ?>" id="Excluir" name="Excluir" />
								</td>
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