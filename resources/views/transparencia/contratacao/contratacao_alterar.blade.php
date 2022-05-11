@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">ALTERAR CONTRATAÇÕES:</h3>
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
					<form action="{{\Request::route('updateContratos'), $unidade->id}}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<table border="0" class="table table-sm">
							<?php if (sizeof($contratos) > 0) { ?>
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
									<td>
										<!--a class="btn btn-danger btn-sm" style="" href="{{route('pesquisarPrestador', $unidade->id)}}" > Pesquisar <i class="fas fa-search"></i></a-->
									</td>
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
										<!--a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('prestadorCadastro', $unidade->id)}}" > Novo Prestador <i class="fas fa-check"></i></a-->
									</td>
								</tr>
								<tr>
									<td> <br /> <br /> </td>
								</tr>

								<input type="hidden" id="prestador_id" name="prestador_id" value="" />
								<input type="hidden" id="contrato_id" name="contrato_id" value="<?php echo $contratos[0]->id; ?>" />
								<tr>
									<td> Título: </td>
									<td> <input class="form-control" type="text" id="objeto" name="objeto" value="<?php echo $contratos[0]->objeto; ?>" required /> </td>
								</tr>
								<tr>
									<td> Tipo: </td>
									<td>
										<select style="width: 150px;" name="aditivos" id="aditivos" onchange="exibir('vinculo')" style="width: 300px;" class="form-control" disabled>
											<option name="aditivos" id="aditivos" value="0"> Contrato </option>
										</select>
									</td>
								</tr>
								<tr>
									<td> Valor: </td>
									<td> <input style="width: 100px;" class="form-control" type="number" id="valor" name="valor" value="<?php echo $contratos[0]->valor; ?>" required /> </td>
								</tr>
								<tr>
									<td> Início: </td>
									<td> <input style="width: 200px;" class="form-control" type="date" id="inicio" name="inicio" value="<?php echo $contratos[0]->inicio; ?>" required /> </td>
								</tr>
								<tr>
									<td> Fim: </td>
									<td> <input style="width: 200px;" class="form-control" type="date" id="fim" name="fim" value="<?php echo $contratos[0]->fim; ?>" required /> </td>
								</tr>
								<tr>
									<td> Renovação Automática: </td>
									<td>
										<select style="width: 100px;" name="renovacao_automatica" id="renovacao_automatica" class="form-control">
											<?php if ($contratos[0]->renovacao_automatica == 0) { ?>
												<option value="0"> Não </option>
											<?php } else { ?>
												<option value="1"> Sim </option>
											<?php } ?>
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
									<td> <input style="width: 800px;" class="form-control" type="text" id="file_path_" name="file_path_" value="<?php echo $contratos[0]->file_path; ?>" readonly="true" title="{{$contratos[0]->file_path}}" /> </td>
								</tr>
								<tr>
									<td>
									<td> <input style="width: 800px;" class="form-control" type="file" id="file_path" name="file_path" value="<?php echo $contratos[0]->file_path; ?>" /> </td>
									</td>
								</tr>
							<?php } else {
							} ?>
						</table>
						<table>
							<tr>
								<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
								<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="contratacao" /> </td>
								<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="alterarContratacao" /> </td>
								<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							</tr>
						</table>
						<table>
							<input type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
							<?php if (sizeof($contratos) > 0) { ?>
								<input type="hidden" id="id" name="id" value="<?php echo $contratos[0]->id; ?>" />
							<?php } else {
							} ?>
							<tr>
								<table class="table table-sm" id="" name="">
									<thead>
										<tr>
											<th scope="col">CNPJ</th>
											<th scope="col">Empresa</th>
											<th scope="col">Visualizar</th>
											<th scope="col">Tipo</th>
											<th scope="col">Contrato</th>
											<th scope="col">Alterar</th>
											<th scope="col">Excluir</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										<?php $j = 1; ?>
										<?php $a = 1; ?>
										<?php $c = 1; ?>
										<?php $id = 0; ?>
										<?php $aditivoVincula = 1; ?>
										@foreach ($vinculos as $contrato)
										<tr>
											<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->cnpj_cpf}}">{{$contrato->cnpj_cpf}}</td>
											<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->prestador}}">{{$contrato->prestador}}</td>
											<td>
												@if($contrato->ativa == 1 && $contrato->inativa == 0)
												<a class="badge badge-pill badge-primary dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false" href="{{$contrato->file_path}}" target="_blank">
													Visualizar
												</a>
												@elseif($contrato->ativa == 0 && $contrato->inativa == 0)
												<a class="badge badge-pill badge-primary dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false" href="{{asset('storage')}}/{{$contrato->file_path}}" target="_blank">
													Visualizar
												</a>
												@endif

											</td>
											<td>
												@if($contrato->opcao == 0)
												<?php $c++; ?>
												{{$c}}º Contrato
												@elseif($contrato->opcao == 1)
												<?php
												$id += 1;
												if (substr($contrato->vinculado, 0, 1) != $aditivoVincula) {
													$id = 1;
												}
												$aditivoVincula = substr($contrato->vinculado, 0, 1)
												?>
												{{$id}}º Aditivo
												@elseif($contrato->opcao == 2)
												Distrato
												@endif
											</td>
											@if($contrato->opcao !== 0)
											<td>
												<center>
													<input type="hidden" id="id_<?php echo $i ?>" name="id_<?php echo $i ?>" value="<?php echo $contrato->aditivo_ID; ?>" />
													<?php $i++; ?>
													<select style="width: 150px;" name="cont_<?php echo $j ?>" id="cont_<?php echo $j ?>" style="width: 300px;" class="form-control">
														<option name="cont_<?php echo $j ?>" id="cont_<?php echo $j ?>" value="1º Contrato">1° Contrato </option>
														@foreach($ccontratos as $cont)
														<?php $a++; ?>
														@if($a.'º Contrato' == $contrato->vinculado)
														<option name="cont_<?php echo $j ?>" id="cont_<?php echo $j ?>" value="<?php echo $a . 'º Contrato'; ?>" selected>{{$a.'° Contrato'}}</option>
														@else
														<option name="cont_<?php echo $j ?>" id="cont_<?php echo $j ?>" value="<?php echo $a . 'º Contrato'; ?>">{{$a.'° Contrato'}}</option>
														@endif
														@endforeach
													</select>
												</center>
											</td>
											<input type="hidden" id="i" name="i" value="<?php echo $j ?>" />
											<?php $j++; ?>
											@else
											<td>
											</td>
											@endif
											<div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
												<a id="div" class="dropdown-item" target="_blank">Contrato</a>
												@foreach($vinculos as $aditivo)
												<strong><a id="div" class="dropdown-item" href="{{asset('storage')}}" target="_blank">Contrato</a></strong>
												@endforeach
											</div>
											</td>
											<td> <a class="btn btn-info btn-sm" href="{{route('alterarAditivo', array($unidade->id, $contrato->aditivo_ID,$contrato->cont_id))}}" style="color: #FFFFFF;" href=><i class="fas fa-edit"></i></a> </td>
											<td> <a class="btn btn-danger btn-sm" href="{{route('excluirAditivo', array($unidade->id, $contrato->aditivo_ID))}}" style="color: #FFFFFF;" href=><i class="fas fa-trash"></i></a> </td>
										</tr>
										<?php $a = 1; ?>
										@endforeach
									</tbody>
								</table>
								<table>
									<td align="left"> <br /><br /> <a href="{{route('contratacaoCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
										<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
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