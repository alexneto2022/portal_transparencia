@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">EXCLUIR CONTRATOS DE GESTÃO / ADITIVOS:</h3>
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
		<div class="col-md-0 col-sm-0"></div>
		<div class="col-md-12 col-sm-12 text-center">
			<div id="accordion">
				<div class="card ">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						Contratos de Gestão / Aditivos <i class="fas fa-check-circle"></i>
					</a>
				</div>
						<form action="{{\Request::route('destroy'), $unidade->id}}" method="post">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table border="0" class="table-sm" style="line-height: 1.5;">
								<tr>
								 <td> <strong>ID:</strong> </td>
								 <td> <input class="form-control" style="width: 100px;" readonly="true" type="text" id="id" name="id" value="<?php echo $contratos[0]->id; ?>" /> </td>
								</tr>
							    <tr>
								 <td> <br/> <strong>Título:</strong> </td>
								 <td> <br/> <input style="width: 400px;" class="form-control" readonly="true" type="text" id="title" name="title" value="<?php echo $contratos[0]->title; ?>" /> </td> 
								</tr> 
								<tr>
								 <td> <br/> <strong> Caminho: </strong> </td>
								 <td> <br/> <input style="width: 500px;" readonly="true" class="form-control" type="text" id="path_file" name="path_file" value="<?php echo $contratos[0]->path_file; ?>" /> </td>
								</tr>
							</table>
							
							<table>
							  <tr>
							    <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
								<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="ContratoGestao" /> </td>
								<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="excluirContratoGestao" /> </td>
								<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							  </tr>
							</table>
							
							<table>
								<tr>
								  <td align="left"> <br />
									<p><h6 align="left"> Deseja realmente Excluir este Contrato de Gestão?? </h6></p>
									<a href="{{route('contratoCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
									<input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir" id="Excluir" name="Excluir" />
								  </td>
								</tr>
							</table>
						</form>
						</div>
					</div>
				</div>
			</div>
		</div> 
	</div>
		<br /> <br />
		
	<div class="col-md-2 col-sm-0"></div>
</div>
@endsection