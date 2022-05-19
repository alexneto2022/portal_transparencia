@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">EXCLUIR REGIMENTO INTERNO:</h5>
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
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div id="accordion">
				<div class="card ">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						Regimento Interno: <i class="fas fa-check-circle"></i>
					</a>
					<div class="card-body" style="font-size: 14px;">
						<form action="{{\Request::route('store'), $unidade->id}}" method="post" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							<div class="form-control mt-3">
								<div class="form-row mt-2">
									<div class="form-group col-md-12">
										<label><strong>Título:</strong></label>
										<input style="" class="form-control" type="text" id="title" name="title" value="<?php echo $regimentos[0]->title; ?>" readonly="true" />
									</div>
								</div>
								<div class="form-row mt-2 align-items-center">
									<div class="form-group col-md-12">
										<label> <strong> Arquivo: </strong></label>
										<input class="form-control" type="text" id="file_path" name="file_path" readonly="true" value="<?php echo $regimentos[0]->file_path; ?>" />
									</div>
								</div>
							</div>
							<table>
								<tr>
									<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
									<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="regimentoInterno" /> </td>
									<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="excluirRegimentoInterno" /> </td>
									<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
								</tr>
							</table>

							<div>
								<p>
								<h6> Deseja realmente Excluir este Regimento Interno?? </h6>
								</p>
							</div>
							<div class="d-flex justify-content-around">
								<div class="p-2">
									<a href="{{route('regimentoCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
								</div>
								<div class="p-2">
									<input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir" id="Excluir" name="Excluir" />
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection