@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR DOCUMENTAÇÃO DE REGULARIDADE:</h3>
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
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Documentação de Regularidade <i class="fas fa-check-circle"></i>
                    </a>
                </div>
                    <form method="post" action="{{ \Request::route('store'), $unidade->id }}" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table border="0" class="table-sm" style="line-height: 1.5;" WIDTH="1020">
					  <tr>
					    <td> Título: </td>
						<td> <input class="form-control" style="width: 400px;" type="text" id="name" name="name" value="" required /> </td> 
					  </tr>
					  <tr>
						<td> Tipo de Documento: </td>
						<td> 
							<select class="form-control" style="width: 400px;" id="type_id" name="type_id" value="" required />
								<?php $qtd = sizeof($types); for ( $i = 0; $i < $qtd; $i++ ) { ?>
									<option value="<?php echo $types[$i]->id; ?>"><?php echo $types[$i]->type_name; ?></option>
								<?php } ?>
							</select>
						</td> 
					  </tr>
					  <tr>
						<td> Arquivo: </td>
						<td> <input class="form-control" style="width: 400px;" type="file" id="path_file" name="path_file" value="" required /> </td>
					  </tr>
					  <td colspan="2"> <input type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /> </td>
					</table>
					
					<table>
						 <tr>
						   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
						   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="documentosRegularidade" /> </td>
						   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarDocumentosRegularidade" /> </td>
						   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						 </tr>
					</table>
					
					<table>
					 <tr>
					   <td align="left">
						 <a href="{{route('documentosCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
					     <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> 
					   </td>
					 </tr>
					</table>
                  </div>
            </div>
        </div>
		<div class="col-md-0 col-sm-0"></div>
    </div>
</div>
@endsection