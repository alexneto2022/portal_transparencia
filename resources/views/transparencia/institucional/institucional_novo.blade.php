@extends('navbar.default-navbar')



@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">CADASTRAR INSTITUCIONAL:</h5>
		</div>
	</div><br />
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
	<form action="{{\Request::route('store')}}" method="post" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="form-row mt-2">
			<div class="form-group col-md-12">
				<label><strong>Perfil:</strong></label>
				<input type="text" class="form-control" name="owner" id="owner" readonly="true" value="Sociedade Pernambucana de Combate ao Câncer" required />
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-5">
				<label><strong>CNPJ: </strong></label>
				<input type="text" maxlength="18" class="form-control" name="cnpj" id="cnpj" value="" required />
			</div>
			<div class="form-group col-md-5">
				<label><strong>Nome Unidade: </strong></label>
				<input type="text" class="form-control" name="name" id="name" value="" required />
			</div>
            <div class="form-group col-md-2">
				<label><strong>Sigla: </strong></label>
				<input type="text" class="form-control" name="sigla" id="sigla" value="" required />
			</div>
		</div>
		@if(isset($unidade->further_info) || $unidade->further_info !== null)
		<div class="form-row">
			<div class="form-group col-md-2">
				<label><strong>CEP: </strong></label>
				<input type="text" class="form-control" name="cep" id="cep" value="" required />
			</div>
			<div class="form-group col-md-6">
				<label><strong>Logradouro: </strong></label>
				<input type="text" class="form-control" name="address" id="address" value="" required />
			</div>
			<div class="form-group col-md-4">
				<label><strong>Complemento: </strong> </label>
				<input type="text" class="form-control" name="further_info" id="further_info" value="" required />
			</div>
		</div>
		@else
		<div class="form-row">
			<div class="form-group col-md-2">
				<label><strong>CEP: </strong></label>
				<input type="text" class="form-control" name="cep" id="cep" value="" required />
			</div>
			<div class="form-group col-md-10">
				<label><strong>Logradouro: </strong></label>
				<input type="text" class="form-control" name="address" id="address" value="" required />
			</div>
		</div>
		@endif
		<div class="form-row">
			<div class="form-group col-md-5">
				<label><strong>Bairro: </strong></label>
				<input type="text" class="form-control" name="district" id="district" value="" required />
			</div>
			<div class="form-group col-md-5">
				<label><strong>Cidade:</strong></label>
				<input type="text" class="form-control" name="city" id="city" value="" required />
			</div>
			<div class="form-group col-md-2">
				<label><strong>UF: </strong></label>
				<input type="text" class="form-control" name="uf" id="uf" value="" required />
			</div>
		</div>
		@if(isset($unidade->cnes) || $unidade->cnes !== null)
		<div class="form-row">
			<div class="form-group col-md-4">
				<strong>Telefone: </strong>
				<input type="text" maxlength="13" class="form-control" name="telefone" id="telefone" value="" required />
			</div>
			<div class="form-group col-md-4">
				<strong>Horário: </strong>
				<input type="text" class="form-control" name="time" id="time" value="" required />
			</div>
			<div class="form-group col-md-4">
				<strong>CNES:</strong>
				<input type="text" class="form-control" name="timeCnes" id="timeCnes" value="" required />
			</div>
		</div>
		@else
		<div class="form-row">
			<div class="form-group col-md-6">
				<label><strong>Telefone: </strong></label>
				<input type="text" maxlength="13" class="form-control" name="telefone" id="telefone" value="" required />
			</div>
			<div class="form-group col-md-6">
				<label><strong>Horário: </strong></label>
				<input type="text" class="form-control" name="time" id="time" value="" required />
			</div>
		</div>
		@endif
		<div class="form-row">
			<div class="form-group col-md-6">
				<label><strong>Imagem: </strong></label>
				<input type="file" class="form-control" name="path_img" id="path_img" value="" required />
			</div>
			<div class="form-group col-md-6">
				<label><strong>Ícone: </strong></label>
				<input type="file" class="form-control" name="icon_img" id="icon_img" value="" required />
			</div>
		</div>
		<div class="form-row mt-1">
			<div class="form-group col-md-12">
				<label><strong>Google Maps: </strong></label>
				<input type="text" placeholder="Pesquise e cole o link do mapa do google maps" class="form-control" name="google_maps" id="google_maps" value="" required />
			</div>
		</div>
		<div class="form-row mt-1">
			<div class="form-group col-md-12">
				<label><strong>Capacidade: </strong></label>
				<textarea class="form-control autoTxtArea" maxlength="2500" id="capacity" name="capacity" cols="20" rows="1"> </textarea>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-12">
				<label><strong>Especialidades: </strong></label>
				<textarea maxlength="2500" id="specialty" name="specialty" class="form-control autoTxtArea" rows="1"></textarea>
			</div>
		</div>
		<input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
		<input hidden type="text" class="form-control" id="tela" name="tela" value="institucional" />
		<input hidden type="text" class="form-control" id="acao" name="acao" value="salvarInstitucional" />
		<input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" />

		<div class="form-row">
			<div class="form-group text-center col-md-6">
				<a href="{{route('trasparenciaHome', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
			</div>
			<div class="form-group text-center col-md-6">
				<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
			</div>
		</div>
	</form>
</div>

<script>
	document.addEventListener('keydown', function(event) { //pega o evento de precionar uma tecla
		if (event.keyCode != 46 && event.keyCode != 8) { //verifica se a tecla precionada nao e um backspace e delete
			var i = document.getElementById("telefone").value.length; //aqui pega o tamanho do input
			if (i === 0)
				document.getElementById("telefone").value = document.getElementById("telefone").value + "(";
			if (i === 3)
				document.getElementById("telefone").value = document.getElementById("telefone").value + ")";
			if (i === 8) //aqui faz a divisoes colocando um ponto no terceiro e setimo indice
				document.getElementById("telefone").value = document.getElementById("telefone").value + "-";
		}
	});

	document.addEventListener('keydown', function(event) { //pega o evento de precionar uma tecla
		if (event.keyCode != 46 && event.keyCode != 8) { //verifica se a tecla precionada nao e um backspace e delete
			var i = document.getElementById("cnpj").value.length; //aqui pega o tamanho do input
			if (i === 2)
				document.getElementById("cnpj").value = document.getElementById("cnpj").value + ".";
			if (i === 6)
				document.getElementById("cnpj").value = document.getElementById("cnpj").value + ".";
			if (i === 10) //aqui faz a divisoes colocando um ponto no terceiro e setimo indice
				document.getElementById("cnpj").value = document.getElementById("cnpj").value + "/";
			if (i === 15) //aqui faz a divisoes colocando um ponto no terceiro e setimo indice
				document.getElementById("cnpj").value = document.getElementById("cnpj").value + "-";
		}
	});

	document.addEventListener('keydown', function(event) { //pega o evento de precionar uma tecla
		if (event.keyCode != 46 && event.keyCode != 8) { //verifica se a tecla precionada nao e um backspace e delete
			var i = document.getElementById("cep").value.length; //aqui pega o tamanho do input
			if (i === 2)
				document.getElementById("cep").value = document.getElementById("cep").value + ".";
			if (i === 6)
				document.getElementById("cep").value = document.getElementById("cep").value + "-";
		}
	});
	//Auto ajuste do text-area da capacidade
	var txtAreas = document.querySelectorAll('.autoTxtArea');
	for (x = 0; x < txtAreas.length; x++) {
		txtAreas[x].addEventListener('input', function() {
			if (this.scrollHeight > this.offsetHeight) this.rows += 1;
		});
	}
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#telefone').mask('0000-0000');
	});
</script>


@endsection