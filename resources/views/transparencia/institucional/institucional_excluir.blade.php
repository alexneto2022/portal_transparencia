@extends('navbar.default-navbar')



@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">EXCLUIR INSTITUCIONAL:</h5>
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
	<div class="d-flex flex-column">
		<div>
			<a class="form-control text-center bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
				Institucional: <i class="fas fa-check-circle"></i>
			</a>
		</div>
	</div>
	<form action="{{\Request::route('destroy', $unidade->id)}}" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="form-row mt-2">
			<div class="form-group col-md-12">
				<label><strong>Perfil:</strong></label>
				<input type="text" class="form-control" name="owner" id="owner" readonly="true" value="Sociedade Pernambucana de Combate ao Câncer" value="<?php echo $unidade->owner; ?>" disabled />
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label><strong>CNPJ: </strong></label>
				<input type="text" maxlength="18" class="form-control" name="cnpj" id="cnpj" value="<?php echo $unidade->cnpj; ?>" disabled />
			</div>
			<div class="form-group col-md-6">
				<label><strong>Nome Unidade: </strong></label>
				<input type="text" class="form-control" name="name" id="name" value="<?php echo $unidade->name; ?>" disabled />
			</div>
		</div>
		@if(isset($unidade->further_info) || $unidade->further_info !== null)
		<div class="form-row">
			<div class="form-group col-md-2">
				<label><strong>CEP: </strong></label>
				<input type="text" class="form-control" name="cep" id="cep" value="<?php echo $unidade->cep; ?>" disabled />
			</div>
			<div class="form-group col-md-6">
				<label><strong>Logradouro: </strong></label>
				<input type="text" class="form-control" name="address" id="address" value="<?php echo $unidade->address; ?>" disabled />
			</div>
			<div class="form-group col-md-4">
				<label><strong>Complemento: </strong> </label>
				<input type="text" class="form-control" name="further_info" id="further_info" value="<?php echo $unidade->further_info; ?>" disabled />
			</div>
		</div>
		@else
		<div class="form-row">
			<div class="form-group col-md-2">
				<label><strong>CEP: </strong></label>
				<input type="text" class="form-control" name="cep" id="cep" value="<?php echo $unidade->cep; ?>" disabled />
			</div>
			<div class="form-group col-md-10">
				<label><strong>Logradouro: </strong></label>
				<input type="text" class="form-control" name="address" id="address" value="<?php echo $unidade->address; ?>" disabled />
			</div>
		</div>
		@endif
		<div class="form-row">
			<div class="form-group col-md-5">
				<label><strong>Bairro: </strong></label>
				<input type="text" class="form-control" name="district" id="district" value="<?php echo $unidade->district; ?>" disabled />
			</div>
			<div class="form-group col-md-5">
				<label><strong>Cidade:</strong></label>
				<input type="text" class="form-control" name="city" id="city" value="<?php echo $unidade->city; ?>" disabled />
			</div>
			<div class="form-group col-md-2">
				<label><strong>UF: </strong></label>
				<input type="text" class="form-control" name="uf" id="uf" value="<?php echo $unidade->uf; ?>" disabled />
			</div>
		</div>
		@if(isset($unidade->cnes) || $unidade->cnes !== null)
		<div class="form-row">
			<div class="form-group col-md-4">
				<strong>Telefone: </strong>
				<input type="text" maxlength="13" class="form-control" name="telefone" id="telefone" value="<?php echo $unidade->telefone; ?>" disabled />
			</div>
			<div class="form-group col-md-4">
				<strong>Horário: </strong>
				<input type="text" class="form-control" name="time" id="time" value="<?php echo $unidade->time; ?>" disabled />
			</div>
			<div class="form-group col-md-4">
				<strong>CNES:</strong>
				<input type="text" class="form-control" name="timeCnes" id="timeCnes" value="<?php echo $unidade->cnes; ?>" disabled />
			</div>
		</div>
		@else
		<div class="form-row">
			<div class="form-group col-md-6">
				<label><strong>Telefone: </strong></label>
				<input type="text" maxlength="13" class="form-control" name="telefone" id="telefone" value="<?php echo $unidade->telefone; ?>" disabled />
			</div>
			<div class="form-group col-md-6">
				<label><strong>Horário: </strong></label>
				<input type="text" class="form-control" name="time" id="time" value="<?php echo $unidade->time; ?>" disabled />
			</div>
		</div>
		@endif
		<div class="form-row">
			<div class="form-group col-md-6">
				<label><strong>Imagem: </strong></label>
				<input type="text" readonly="true" class="form-control" name="path_img" id="path_img" style="width:300px" value="<?php echo $unidade->path_img; ?>" disabled />
			</div>
			<div class="form-group col-md-6">
				<label><strong>Ícone: </strong></label>
				<input type="text" readonly="true" class="form-control" name="icon_img" id="icon_img" style="width:300px" value="<?php echo $unidade->icon_img; ?>" disabled />

			</div>
		</div>
		<div class="form-row mt-1">
			<div class="form-group col-md-12">
				<label><strong>Google Maps: </strong></label>
				<input type="text" placeholder="Pesquise e cole o link do mapa do google maps" class="form-control" name="google_maps" id="google_maps" value="<?php echo $unidade->google_maps; ?>" disabled />
			</div>
		</div>
		<div class="form-row mt-1">
			<div class="form-group col-md-12">
				<label><strong>Capacidade: </strong></label>
				<textarea class="form-control autoTxtArea" maxlength="2500" id="capacity" name="capacity" cols="20" rows="1" disabled>{{ $unidade->capacity }} </textarea>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-12">
				<label><strong>Especialidades: </strong></label>
				<textarea maxlength="2500" id="specialty" name="specialty" class="form-control autoTxtArea" rows="1" disabled>{{ $unidade->specialty }}</textarea>
			</div>
		</div>
		<table>
			<tr>
				<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
				<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="institucional" /> </td>
				<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="excluirInstitucional" /> </td>
				<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
			</tr>
		</table>
		<table>
			<tr>
				<td>
					<p>
					<h6 align="left"> Deseja realmente Excluir esta Instituição?? </h6>
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<a href="{{route('institucionalCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
					<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Excluir" id="Excluir" name="Excluir" />
				</td>
			</tr>
		</table>

	</form>
</div>
<script>
	window.onload = function() {
		$('#telefone').mask('9999-9999');
	};
</script>
@endsection