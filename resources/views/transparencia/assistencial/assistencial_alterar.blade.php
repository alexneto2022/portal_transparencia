@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row p-2">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">ALTERAR RELATÓRIO ASSISTENCIAL:</h5>
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
	<container>
		<form action="{{\Request::route('update'), $unidade->id}}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="d-flex flex-column">
				<div class="card">
					<a class="form-control text-center bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						RELATÓRIO ASSISTENCIAL: <i class="fas fa-check-circle"></i>
					</a>
				</div>

				<div class="d-inline-flex mt-2 flex-wrap align-items-center justify-content-center form-control">
					<div class="p-2">
						Indicador:
					</div>
					<div class="p-2">
						<select id="indicador_id" name="indicador_id" class="form-control" onchange="exibir_ocultar(this)">
							<option value="1"> 1. Consultas Médicas </option>
							<option value="2"> 2. Comissão de Controle </option>
						</select>
					</div>
					<div class="p-2">
						Ano de Referência:
					</div>
					<div class="p-2">
						<input type="number" id="ano_ref" name="ano_ref" value="<?php if (!empty($anosRef)) {
																					echo $anosRef[0]->ano_ref;
																				} else {
																					echo "";
																				} ?>" class="form-control" style="width: 100px" required />
					</div>
				</div>
				<div class="d-flex flex-column align-items-center mt-2 form-control">
					<div class="d-inline-flex flex-wrap align-items-center justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Descrição: </div>
						<div class="p-1"> <input type="text" id="descricao" name="descricao" value="<?php if (!empty($anosRef)) {
																										echo $anosRef[0]->descricao;
																									} else {
																										echo "";
																									} ?>" class="form-control" style="max-width: auto" required /> </div>
					</div>
					<div class="d-inline-flex flex-wrap align-items-center justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Meta Controlada/Mês: </div>
						<div class="p-1"> <input type="text" id="meta" name="meta" value="<?php if (!empty($anosRef)) {
																								echo $anosRef[0]->meta;
																							} else {
																								echo "";
																							} ?>" class="form-control" style="max-width: auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap align-items-center justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Janeiro: </div>
						<div class="p-1"> <input type="text" id="janeiro" name="janeiro" value="<?php if (!empty($anosRef)) {
																									echo $anosRef[0]->janeiro;
																								} else {
																									echo "";
																								} ?>" class="form-control" style="max-width: auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap align-items-center justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Fevereiro: </div>
						<div class="p-1"><input type="text" id="fevereiro" name="fevereiro" value="<?php if (!empty($anosRef)) {
																										echo $anosRef[0]->fevereiro;
																									} else {
																										echo "";
																									} ?>" class="form-control" style="max-width: auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap align-items-center justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Março: </div>
						<div class="p-1"><input type="text" id="marco" name="marco" value="<?php if (!empty($anosRef)) {
																								echo $anosRef[0]->marco;
																							} else {
																								echo "";
																							} ?>" class="form-control" style="max-width: auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap align-items-center justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Abril: </div>
						<div class="p-1"> <input type="text" id="abril" name="abril" value="<?php if (!empty($anosRef)) {
																								echo $anosRef[0]->abril;
																							} else {
																								echo "";
																							} ?>" class="form-control" style="max-width: auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap align-items-center justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Maio: </div>
						<div class="p-1"> <input type="text" id="maio" name="maio" value="<?php if (!empty($anosRef)) {
																								echo $anosRef[0]->maio;
																							} else {
																								echo "";
																							} ?>" class="form-control" style="max-width: auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap align-items-center justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Junho: </div>
						<div class="p-1"> <input type="text" id="junho" name="junho" value="<?php if (!empty($anosRef)) {
																								echo $anosRef[0]->junho;
																							} else {
																								echo "";
																							} ?>" class="form-control" style="max-width: auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap align-items-center justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Julho: </div>
						<div class="p-1"> <input type="text" id="julho" name="julho" value="<?php if (!empty($anosRef)) {
																								echo $anosRef[0]->julho;
																							} else {
																								echo "";
																							} ?>" class="form-control" style="max-width: auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap align-items-center justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Agosto: </div>
						<div class="p-1"> <input type="text" id="agosto" name="agosto" value="<?php if (!empty($anosRef)) {
																									echo $anosRef[0]->agosto;
																								} else {
																									echo "";
																								} ?>" class="form-control" style="max-width: auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap align-items-center justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Setembro: </div>
						<div class="p-1"> <input type="text" id="setembro" name="setembro" value="<?php if (!empty($anosRef)) {
																										echo $anosRef[0]->setembro;
																									} else {
																										echo "";
																									} ?>" class="form-control" style="max-width: auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap align-items-center justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Outubro: </div>
						<div class="p-1"> <input type="text" id="outubro" name="outubro" value="<?php if (!empty($anosRef)) {
																									echo $anosRef[0]->outubro;
																								} else {
																									echo "";
																								} ?>" class="form-control" style="max-width: auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap align-items-center justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Novembro: </div>
						<div class="p-1"> <input type="text" id="novembro" name="novembro" value="<?php if (!empty($anosRef)) {
																										echo $anosRef[0]->novembro;
																									} else {
																										echo "";
																									} ?>" class="form-control" style="max-width: auto" /> </div>
					</div>
					<div class="d-inline-flex flex-wrap align-items-center justify-content-center text-center">
						<div class="p-1" style="width: 195px;"> Dezembro: </div>
						<div class="p-1"> <input type="text" id="dezembro" name="dezembro" value="<?php if (!empty($anosRef)) {
																										echo $anosRef[0]->dezembro;
																									} else {
																										echo "";
																									} ?>" class="form-control" style="max-width: auto" /> </div>
					</div>
					<div>
						<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
						<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="relAssistencial" /> </td>
						<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarRelAssistencial" /> </td>
						<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
					</div>
				</div>
				<div class="d-inline-flex mt-2 flex-wrap align-items-center justify-content-around form-control">
					<div class="p-2">
						<a href="{{route('assistencialCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
					</div>
					<div class="p-2">
						<input type="submit" class="btn btn-success btn-sm" value="Alterar" id="Salvar" name="Salvar" />
					</div>
				</div>
		</form>
	</container>
</div>
@endsection