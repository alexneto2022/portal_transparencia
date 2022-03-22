@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;"> EXCLUIR ASSISTENCIAL COVID:</h3>
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
                        Assitencial Covid <i class="fas fa-check-circle"></i>
                    </a>
                </div>
                    <form method="post" action="{{ \Request::route('destroy'), $unidade->id }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					@foreach($assistencialCovid as $covid)
					<table border="0" class="table-sm" style="line-height: 1.5;">
					  <tr>
					    <td> Título: </td>
						<td> <input class="form-control" style="width: 500px;" type="text" id="titulo" name="titulo" value="<?php echo $covid->titulo; ?>" readonly="true" /> </td> 
					  </tr>
					  <tr>
						<td> Mês: </td>
						<td> <input type="text" class="form-control" style="width: 300px" id="mes" name="mes" value="<?php echo $covid->mes; ?>" /> </td>
					  </tr>
					  <tr>
						<td> Ano: </td>
						<td> <input type="text" class="form-control" style="width: 300px" id="ano" name="ano" value="<?php echo $covid->ano; ?>" /> </td>
					  </tr>
					  <tr>
						<td> Arquivo: </td>
						<td> <input class="form-control" style="width: 600px;" type="text" id="path_file" name="path_file" value="<?php echo $estatutos->path_file; ?>" readonly="true" /> </td> 
					  </tr>
					  <td colspan="2"> <input type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /> </td>
					</table>				
					@endforeach
					<table>
						 <tr>
						   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
						   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="estatutoAta" /> </td>
						   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="excluirEstatutoAta" /> </td>
						   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						 </tr>
					</table>				
					<br/>
					<table>
					 <tr>
					   <td align="left">
						 <p><h6 align="left"> Deseja realmente Excluir este Estatuto/Ata?? </h6></p>
						 <a href="{{route('estatutoCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
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