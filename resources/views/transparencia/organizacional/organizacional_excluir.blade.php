@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">EXCLUIR ESTRUTURA ORGANIZACIONAL:</h5>
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
		<div class="col-md-1 col-sm-0"></div>
		<div class="col-md-10 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						ESTRUTURA ORGANIZACIONAL: <i class="fas fa-check-circle"></i>
					</a>
				</div>
				<form action="{{\Request::route('store'), $unidade->id}}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-control mt-3">
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Nome:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input readonly="true" class="form-control" type="text" id="name" name="name" value="<?php echo $organizacionals[0]->name; ?>" />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label> <strong> Cargo: </strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input readonly="true" class="form-control" type="text" id="cargo" name="cargo" value="<?php echo $organizacionals[0]->cargo; ?>" />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label> <strong> E-mail: </strong></label>
								</div>
								<div class="col-sm-10 mr-2">
									<input readonly="true" class="form-control" type="text" id="email" name="email" value="<?php echo $organizacionals[0]->email; ?>" />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label> <strong> Telefone: </strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input readonly="true" class="form-control" type="text" id="telefone" name="telefone" value="<?php echo $organizacionals[0]->telefone; ?>" />
								</div>
							</div>
						</div>
					</div>
					<table>
						<tr>
							<input hidden style="width: 450px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="Organizacional" /> </td>
							<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="excluirOrganizacional" /> </td>
							<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						</tr>
					</table>
					<div>
						<p>
						<h6> Deseja realmente Excluir esta Estrutura Organizacional?? </h6>
						</p>
					</div>
					<div class="d-flex justify-content-around">
						<div class="p-2">
							<a href="{{route('organizacionalCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						</div>
						<div class="p-2">
							<input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir" id="Salvar" name="Salvar" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endsection