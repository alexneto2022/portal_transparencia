@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;"> ALTERAR COMPETÊNCIAS:</h3>
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
                        Matriz de competência <i class="fas fa-check-circle"></i>
                    </a>
                    <form method="post" action="{{ \Request::route('update', $competenciasMatriz[0]->id) }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table border="0" class="table-sm" style="line-height: 1.5;" WIDTH="1020">
					  <tr>
					    <td colspan="2"> <input class="form-control" type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $competenciasMatriz[0]->unidade_id; ?>" /> </td>
					  </tr>
					  <tr>
					    <td> Setor: </td>
						<td> <input class="form-control" style="width: 400px;" readonly="true" type="text" id="setor" name="setor" value="<?php echo $competenciasMatriz[0]->setor; ?>" /> </td> 
					  </tr>
					  
					  <tr>
						<td> Cargo: </td>
						<td> <input class="form-control" style="width: 400px;" readonly="true" type="text" id="cargo" name="cargo" value="<?php echo $competenciasMatriz[0]->cargo; ?>" /> </td> 
					  </tr>
					  
					  <tr>
						<td> Descrição: </td>
						<td> <textarea class="form-control" type="textarea" cols="10" rows="10" id="descricao" name="descricao" value=""  ><?php echo $competenciasMatriz[0]->descricao; ?></textarea> </td>
					  </tr>
					</table>
					
					<table>
					   <tr>
						 <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="Competencias" /> </td>
						 <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="alterarCompetencias" /> </td>
						 <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
					   </tr>
					</table>
					
					<br/>
					<table>
					 <tr>
					   <td align="left">
						 <a href="{{route('competenciaCadastro', array($unidade->id, $competenciasMatriz[0]->id))}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
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