@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">ALTERAR MEMBROS DIRIGENTES:</h5>
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
						CONSELHO DE ADMINISTRAÇÃO <i class="fas fa-check-circle"></i>
					</a>
					</div>
						<form action="{{\Request::route('update'), $unidade->id}}" method="post" />
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table class="table table-sm">
								<tr hidden>
								    <td hidden> ID: </td>
									<td> <input class="form-control" hidden style="width: 80px;" type="text" id="id" name="id" value="<?php echo $conselhoAdm->id; ?>" disabled="true"  /> </td>
								</tr>
								<tr>
									<td> Nome: </td>
									<td> <input class="form-control" style="width: 450px;" type="text" id="name" name="name" value="<?php echo $conselhoAdm->name; ?>" /> </td>
								</tr>
								<tr>
									<td> Cargo: </td>
									<td> <input class="form-control" style="width: 450px;" type="text" id="cargo" name="cargo" value="<?php echo $conselhoAdm->cargo; ?>" /> </td>
								</tr>
								<tr>
									<td> Tipo Membro: </td>
									<td> <input class="form-control" readonly="true" style="width: 300px;" type="text" id="tipo_membro" name="tipo_membro" value="Conselho de Administração" /> </td>
								</tr>
							</table>
							
							<table>
							 <tr>
							   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="membrosConselhoAdm" /> </td>
							   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="alterarMembrosConselhoAdm" /> </td>
							   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							 </tr>
							</table>
							
							<table>
								<tr>
									<td>
										<a href="{{route('listarConselhoAdm', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
										<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
									</td>
								</tr>
							</table>
						</form>
			</div>
		</div>
	</div>
@endsection