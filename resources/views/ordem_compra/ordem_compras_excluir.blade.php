@extends('layouts.app')
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        <title>Portal da Transparencia - HCP</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
	   <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
        <style>
        .navbar .dropdown-menu .form-control {
            width: 300px;
        }
        </style>
    </head>
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade[0]->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;"> EXCLUIR ORDENS DE COMPRA:</h3>
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
		<div class="col-md-0 col-sm-0"></div>
		<div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Ordens de Compra <i class="fas fa-check-circle"></i>
                    </a>
                    <form method="post" action="{{ route('destroyOrdemCompra', array($unidade[0]->id,$processos[0]->id)) }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table border="0" class="table">
						<tr> 
							<td> Nº Solicitação </td>
							<td> <input type="text" id="numeroSolicitacao" readonly="true" name="numeroSolicitacao" class="form-control" value="<?php echo $processos[0]->numeroSolicitacao; ?>" /> </td>
							<td> Data da Solicitação </td>
							<td> <input type="date" id="dataSolicitacao" readonly="true" name="dataSolicitacao" class="form-control" value="<?php echo $processos[0]->dataSolicitacao; ?>" /> </td>
							<td> Nº O.C </td>
							<td> <input type="text" id="numeroOC" readonly="true" name="numeroOC" class="form-control" value="<?php echo $processos[0]->numeroOC; ?>" /> </td>
						</tr>
						<tr> 	
							<td> Data de Autorização O.C. </td>
							<td> <input type="date" id="dataAutorizacao" readonly="true" name="dataAutorizacao" class="form-control" value="<?php echo $processos[0]->dataAutorizacao; ?>" /> </td>
							<td> Fornecedor </td>
							<td> <input type="text" id="fornecedor" readonly="true" name="fornecedor" class="form-control" value="<?php echo $processos[0]->fornecedor; ?>" /> </td>
							<td> CNPJ </td>
							<td> <input type="text" id="cnpj" readonly="true" name="cnpj" class="form-control" value="<?php echo $processos[0]->cnpj; ?>" /> </td>
						</tr>
					</table>
					
					<table>
						<tr>
						    <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="excluir_planilha_oc"> </td>  
							<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="delete_planilha_oc"> </td>  
							<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade[0]->id; ?>" /></td>
						 </tr>
					</table>
					
					<br/><br/>
					<p><h6 align="left"> <b>Deseja realmente Excluir esta Ordem de Compra?</b> </h6></p>
					<table>
					 <tr>
					   <td align="left">
						 <a href="{{route('transparenciaOrdemCompra', array($unidade[0]->id, $processos[0]->id))}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
					     <input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir" id="Excluir" name="Excluir" /> 
					   </td>
					 </tr>
					</table>
                  </div>
				</form>
            </div>
        </div>
		<div class="col-md-0 col-sm-0"></div>
    </div>
</div>
@endsection