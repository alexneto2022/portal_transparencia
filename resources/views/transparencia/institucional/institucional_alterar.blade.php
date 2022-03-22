@extends('navbar.default-navbar')

	<script>
		window.onload = function(){
			$('#telefone').mask('9999-9999');
		};
	</script>

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 text-center">
            <h5 style="font-size: 18px;">ALTERAR INSTITUCIONAL:</h5>
        </div> 
    </div><br/>
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
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						INSTITUCIONAL: <i class="fas fa-check-circle"></i>
					</a>
				</div>
				<form action="{{\Request::route('update', $unidade->id)}}" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="row">
					<div class="col-md-7" style="font-size: 13px;">  
						<table border="0" class="table-sm" style="line-height: 1.5;">
							<tbody>
								 <tr>
									<td style="border-top: none;"><strong>Perfil: </strong></td>
									<td style="border-top: none;"><input type="text"  class="form-control" name="owner" id="owner" style="width:500px" value="<?php echo $unidade->owner; ?>" required />  </td>
								</tr>
								<tr>
									<td style="border-top: none;"><strong>CNPJ: </strong></td>
									<td style="border-top: none;"><input type="text"  class="form-control" name="cnpj" id="cnpj" style="width:200px" value="<?php echo $unidade->cnpj; ?>" required />  </td>
								</tr>
								<tr>
									<td style="border-top: none;"><strong>Nome Unidade: </strong></td>
									<td style="border-top: none;"><input type="text"  class="form-control" name="name" id="name" style="width:500px" value="<?php echo $unidade->name; ?>" required />  </td>
								</tr>
								<tr>
									<td style="border-top: none;"><strong>Logradouro: </strong></td>
									<td style="border-top: none;"><input type="text"  class="form-control" name="address" id="address" style="width:500px" value="<?php echo $unidade->address; ?>" required />  </td>
								</tr>
								@if(isset($unidade->further_info) || $unidade->further_info !== null)
								<tr>
									<td style="border-top: none;"><strong>Complemento: </strong></td>
									<td style="border-top: none;"><input type="text"  class="form-control" name="further_info" id="further_info" style="width:200px" value="<?php echo $unidade->further_info; ?>" required />  </td>
								</tr>
								@endif
								<tr>
									<td style="border-top: none;"><strong>Bairro: </strong></td>
									<td style="border-top: none;"><input type="text"  class="form-control" name="district" id="district" style="width:200px" value="<?php echo $unidade->district; ?>" required />  </td>
								</tr>
								<tr>
									<td style="border-top: none;"><strong>Cidade: </strong></td>
									<td style="border-top: none;"><input type="text"  class="form-control" name="city" id="city" style="width:200px" value="<?php echo $unidade->city; ?>" required />  </td>
								</tr>
								<tr>
									<td style="border-top: none;"><strong>UF: </strong></td>
									<td style="border-top: none;"><input type="text"  class="form-control" name="uf" id="uf" style="width:200px" value="<?php echo $unidade->uf; ?>" required />  </td>
								</tr>
								<tr>
									<td style="border-top: none;"><strong>CEP: </strong></td>
									<td style="border-top: none;"><input type="text"  class="form-control" name="cep" id="cep" style="width:200px" value="<?php echo $unidade->cep; ?>" required />  </td>
								</tr>
								<tr>
									<td style="border-top: none;"><strong>Telefone: </strong></td>
									<td style="border-top: none;"><input type="text"  class="form-control" name="telefone" id="telefone" style="width:200px" value="<?php echo $unidade->telefone; ?>" required />  </td>
								</tr>
								<tr>
									<td style="border-top: none;"><strong>Horário: </strong></td>
									<td style="border-top: none;"><input type="text"  class="form-control" name="time" id="time" style="width:200px" value="<?php echo $unidade->time; ?>" required />  </td>
								</tr>
								@if(isset($unidade->cnes) || $unidade->cnes !== null)
								<tr>
									<td style="border-top: none;"><strong>CNES: </strong></td>
									<td style="border-top: none;"><input type="text"  class="form-control" name="timeCnes" id="timeCnes" style="width:200px" value="<?php echo $unidade->cnes; ?>" required />  </td>
								</tr>
								@endif
								<tr>
									<td style="border-top: none;"><strong>Imagem: </strong></td>
									<td style="border-top: none;"><input type="text" readonly="true" class="form-control" name="path_img" id="path_img" style="width:300px" value="<?php echo $unidade->path_img; ?>" required /> 
									<input type="file" class="form-control" name="path_img" id="path_img" style="width:400px" value="<?php echo $unidade->path_img; ?>" />  </td>
								</tr>
								<tr>
									<td style="border-top: none;"><strong>Ícone: </strong></td>
									<td style="border-top: none;"><input type="text" readonly="true" class="form-control" name="icon_img" id="icon_img" style="width:300px" value="<?php echo $unidade->icon_img; ?>" required />
									<input type="file" class="form-control" name="icon_img" id="icon_img" style="width:400px" value="<?php echo $unidade->icon_img; ?>" />  </td>
								</tr>
								<tr>
									<td style="border-top: none;"><strong>Google Maps: </strong></td>
									<td style="border-top: none;"><input type="text" placeholder="Pesquise e cole o link do mapa do google maps" class="form-control" name="google_maps" id="google_maps" style="width:500px" value="<?php echo $unidade->google_maps; ?>" required />  </td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12"  style="font-size: 13px;">
						<table style="line-height: 1.5;">
							<tbody>
								@if(isset($unidade->capacity) || $unidade->capacity !== null)
								<tr>
									<td class="text-justify" style="border-top: none;" colspan="2" id="txtCapacity"><strong>Capacidade: </strong></td>
								</tr>
								<tr>
									<td style="width: 1000px;"> <textarea  maxlength="2500" id="capacity" name="capacity" class="form-control" cols="20" rows="20">{{ $unidade->capacity }} </textarea> </td>
								</tr>
								<tr>
									&nbsp;&nbsp;&nbsp;&nbsp;
								</tr>
								@endif
								@if(isset($unidade->specialty) || $unidade->specialty !== null)
								<tr>
									<td class="text-justify" style="border-top: none;" colspan="2" id="txtSpecialty"><strong>Especialidades: </strong> </td>
								</tr>
								<tr>
									<td> <textarea maxlength="2500"  id="specialty" name="specialty" class="form-control" rows="20">{{ $unidade->specialty }}</textarea> </td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
				
				<table>
					<tr>
					   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
					   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="institucional" /> </td>
					   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="alterarInstitucional" /> </td>
					   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
					</tr>
				</table>
				
				<table>
					<tr>
						<td>
							<a href="{{route('institucionalCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						</td>
						<td> 
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
@endsection