@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">ALTERAR REPASSES RECEBIDOS:</h3>
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
		<div class="col-md-8 col-sm-8 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Matriz de competência <i class="fas fa-check-circle"></i>
                    </a>
                </div>
					<p>
					<form action="{{\Request::route('update'), $unidade->id}}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					 <table>
					  <tr>
					   <td> Mês: </td>
					   <td>
						<select id="mes" name="mes" class="form-control" readonly="true">
						 <option value="<?php echo $repasses[0]->mes; ?>">{{ $repasses[0]->mes }}</option>
						 </select>
					   </td>
					  </tr>
					  <tr>
					   <td> Ano: </td>
					   <td> <input style="width: 100px" readonly="true" class="form-control" type="text" id="ano" name="ano" value="<?php echo $repasses[0]->ano; ?>" />  </td>
					  </tr>
					  <tr>
					   <td> Contratado: </td>
					   <td> <input class="form-control" type="text" id="contratado" name="contratado" value="<?php echo $repasses[0]->contratado; ?>" />  </td>
					  </tr>
					  <tr>
					   <td> Recebido: </td>
					   <td> <input class="form-control" type="text" id="recebido" name="recebido" value="<?php echo $repasses[0]->recebido; ?>" />  </td>
					  </tr>
					  <tr>
					   <td> Desconto: </td>
					   <td> <input class="form-control" type="text" id="desconto" name="desconto" value="<?php echo $repasses[0]->desconto; ?>" />  </td>
					  </tr>
					 </table>
					 
					 <table>
					   <tr>
						 <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
						 <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="repasses" /> </td>
						 <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="alterarRepasses" /> </td>
						 <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
					   </tr>
					 </table>
					 
					 <table>
					  <tr>
						<td> <br />
							<a href="{{route('repasseCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
						</td>
					  </tr>
					 </table>
					</form>
					</p>
			</div>
		</div>
	</div>
</div>
@endsection