@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">CADASTRAR ORGANOGRAMA:</h5>
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
						Organograma: <i class="fas fa-check-circle"></i>
					</a>
					<div class="card-body" style="font-size: 14px;">
						<form action="{{\Request::route('storeOrganograma'), $unidade->id}}" method="post" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							<div class="form-control mt-3">
								<div class="form-row mt-2">
									<div class="form-group col-md-12">
										<strong>Título:</strong>
										<input class="form-control" type="text" id="title" name="title" value="" required />
									</div>
								</div>
								<div class="form-row mt-2">
									<div class="form-group col-md-12">
										<strong> Arquivo: </strong>
										<input class="form-control" type="file" id="file_path" name="file_path" required value="" />
									</div>
								</div>
							</div>
							<table>
								<tr>
									<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
									<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="regimentoInterno" /> </td>
									<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarRegimentoInterno" /> </td>
									<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
								</tr>
							</table>
							<div class="form-row mt-2 ">
								<div class="form-group text-center col-md-6">
									<a href="{{route('organograma', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
								</div>
								<div class="form-group text-center col-md-6">
									<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
								</div>
							</div>

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