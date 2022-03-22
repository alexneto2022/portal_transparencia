@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">EXCLUIR RECURSOS HUMANOS:</h3>
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
						SELEÇÃO DE PESSOAL <i class="fas fa-check-circle"></i>
					</a>				
				</div>
					<form action="{{\Request::route('destroySelecao'), $unidade->id}}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<table class="table table-sm">
						    <tr>
							  <td> ID: </td>
							  <td> <input readonly="true" class="form-control" style="width: 100px;" type="text" id="id" name="id" value="<?php echo $selecaoPessoal[0]->id; ?>" /> </td>
							</tr>
							<tr>
							  <td> Cargo: </td>
							  <td>  
								<input readonly="true" class="form-control" style="width: 500px;" type="text" id="cargo_name_id" name="cargo_name_id" value="<?php echo $cargos[0]->cargo_name; ?>" />
							  </td>
						    </tr>
							<tr>
							  <td> Quantidade: </td>
							  <td> <input readonly="true" class="form-control" style="width: 100px;" type="text" id="quantidade" name="quantidade" value="<?php echo $selecaoPessoal[0]->quantidade; ?>" /> </td>
							</tr>
							<tr>
							  <td> Ano: </td>
							  <td> <input readonly="true" class="form-control" style="width: 100px;" type="text" id="ano" name="ano" value="<?php echo $selecaoPessoal[0]->ano; ?>" /> </td>
							</tr>
						  </table>
							
						  <table>
							 <tr>
							   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="selecaoPessoal" /> </td>
							   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="excluirSelecaoPessoal" /> </td>
							   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							 </tr>
						  </table>
							
						  <table>
							<tr>
							 <td colspan="2" align="left">
							  <p><h6><br /> Deseja realmente Excluir este RH?? </h6></p>
							  <br /><a href="{{route('selecaoPCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						      <input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir" id="Salvar" name="Salvar" />
							 </td>
							</tr>
						</table> 
					</form>
			</div>
        </div>
		<div class="col-md-1 col-sm-0"></div>
		
    </div>
</div>
@endsection