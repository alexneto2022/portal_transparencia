@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;"> CADASTRAR ASSISTENCIAL COVID:</h3>
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
                        ASSISTENCIAL COVID <i class="fas fa-check-circle"></i>
                    </a>
                </div>
                    <form method="post" action="{{ \Request::route('store'), $unidade->id }}" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table border="0" class="table-sm" style="line-height: 1.5;">
					  <tr>
					    <td> Título: </td>
						<td> <input class="form-control" style="width: 400px;" type="text" id="name" name="name" value="" required /> </td> 
					  </tr>
					  <tr>
					    <td> Mês: </td>
						<td>
						  <select class="form-control" id="mes" name="mes" style="width: 200px">
							<option id="mes" name="mes" value="Janeiro">Janeiro</option>
							<option id="mes" name="mes" value="Fevereiro">Fevereiro</option>
							<option id="mes" name="mes" value="Março">Março</option>
							<option id="mes" name="mes" value="Abril">Abril</option>
							<option id="mes" name="mes" value="Maio">Maio</option>
							<option id="mes" name="mes" value="Junho">Junho</option>
							<option id="mes" name="mes" value="Julho">Julho</option>
							<option id="mes" name="mes" value="Agosto">Agosto</option>
							<option id="mes" name="mes" value="Setembro">Setembro</option>
							<option id="mes" name="mes" value="Outubro">Outubro</option>
							<option id="mes" name="mes" value="Novembro">Novembro</option>
							<option id="mes" name="mes" value="Dezembro">Dezembro</option>
						  </select>
						</td>
					  </tr>
					  <tr>
					    <td> Ano: </td>
						<td> 
						  <select class="form-control" id="ano" name="ano" style="width: 200px">
						   <option id="ano" name="ano" value="2020">2020</option>
						   <option id="ano" name="ano" value="2021" selected>2021</option>
						   <option id="ano" name="ano" value="2022">2022</option>
						   <option id="ano" name="ano" value="2023">2023</option>
						  </select>
						</td>
					  </tr>
					  <tr>
						<td> Arquivo: </td>
						<td> <input class="form-control" style="width: 400px;" type="file" id="file_path" name="file_path" value="" required /> </td> 
					  </tr>
					</table>					
					<table>
						 <tr>
						   <td> <input hidden type="text" class="form-control" id="validar" name="validar" value="0"> </td>
						   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
						   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="assistencialCovid" /> </td>
						   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarAssistencialCovid" /> </td>
						   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						 </tr>
					</table>			
					<br/>
					<table>
					 <tr>
					   <td align="left">
						 <a href="{{route('assistencialCovidCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
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