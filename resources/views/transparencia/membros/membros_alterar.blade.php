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
						ASSOCIADOS EFETIVOS: <i class="fas fa-check-circle"></i>
					</a>
						<form action="{{\Request::route('update'), $unidade->id}}" method="post" />
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table class="table table-sm">
								<tr>
									<td> Nome: </td>
									<td> <input style="width: 400px;" class="form-control" type="text" id="name" name="name" value="<?php echo $associado->name; ?>" required /> </td>
								</tr>
								<tr>
									<td> CPF: </td>
									<td> <input style="width: 300px;" class="form-control" type="text" id="cpf" name="cpf" value="<?php echo $associado->cpf; ?>" required /> </td>
								</tr>
								<tr>
									<td> Tipo Membro: </td>
									<td> <input type="text" style="width: 300px;" readonly="true" class="form-control" id="tipo_membro" name="tipo_membro" value="Associados Efetivos" required /> </td>
								</tr>
							</table>

							<table>
							 <tr>
							   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="membrosDirigentes" /> </td>
							   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="alterarMembrosDirigentes" /> </td>
							   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							 </tr>
							</table>
								
							<table>
								<tr>
									<td> <br />
										<a href="{{route('listarAssociado', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
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