@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">EXCLUIR MEMBROS DIRIGENTES:</h5>
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
				</div>
					<form action="{{\Request::route('destroy'), $unidade->id}}" method="post" />
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<table class="table table-sm">
							<tr>
								<td> ID: </td>
								<td> <input class="form-control" style="width: 100px;" type="type" id="id" name="id" value="<?php echo $associados->id; ?>" disabled="true" /> </td>
							</tr>
							<tr>
								<td> Nome: </td>
								<td> <input class="form-control" style="width: 400px;" type="text" id="name" name="name" value="<?php echo $associados->name; ?>" disabled="true" /> </td>
							</tr>
							<tr>
								<td> CPF: </td>
								<td> <input class="form-control" style="width: 300px;" type="text" id="cpf" name="cpf" value="<?php echo $associados->cpf; ?>" disabled="true" /> </td>
							</tr>
						</table>
						
						<table>
							 <tr>
							   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="membrosDirigentes" /> </td>
							   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="excluirMembrosDirigentes" /> </td>
							   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							 </tr>
						</table>
						
						<table>
							<tr>
								<td>
									<p><h6> Deseja realmente Excluir este Associado Efetivo?? </h6></p>
								</td>
							</tr>
							<tr>
								<td align="left">
									<a href="{{route('listarAssociado', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
									<input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir" id="Excluir" name="Excluir" />
								</td>
							</tr>
						</table>
					</form>
			</div>
		</div>
	</div>
</div>
@endsection