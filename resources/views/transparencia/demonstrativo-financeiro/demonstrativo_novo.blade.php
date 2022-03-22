@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR DEMONSTRATIVOS FINANCEIROS:</h3>
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
		<div class="col-md-8 col-sm-12 text-center">
			<div id="accordion">
				<div class="card ">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Demonstrativos Financeiros: <i class="fas fa-check-circle"></i>
                    </a>
				    <div class="card-body"  style="font-size: 14px;">
						<form action="{{\Request::route('store'), $unidade->id}}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table>
							 <tr>
							   <td> Título: </td>
							   <td> <input class="form-control" readonly="true" type="text" id="title" name="title" value="Relatório Mensal" required /> </td>
							 </tr>
							 <tr>
							   <td> Mês: </td>
							   <td> 
								<select id="mes" name="mes" class="form-control" style="width: 200px">
								    <option value="1">Janeiro</option>
									<option value="2">Fevereiro</option>
									<option value="3">Março</option>
									<option value="4">Abril</option>
									<option value="5">Maio</option>
									<option value="6">Junho</option>
									<option value="7">Julho</option>
									<option value="8">Agosto</option>
									<option value="9">Setembro</option>
									<option value="10">Outubro</option>
									<option value="11">Novembro</option>
									<option value="12">Dezembro</option>
								</select>
							   </td>
							 </tr>
							 <tr>
							<td> Ano: </td>
							<td> <?php $ano = date('Y', strtotime('now')); ?>
							    <select class="form-control" id="ano" name="ano" style="width: 100px;">
							        <?php for($a = 2020; $a <= 2025; $a++) { ?>
							         @if($a == $ano)
							          <option id="ano" name="ano" value="<?php echo $a; ?>" selected>{{ $a }}</option>
							         @else
							          <option id="ano" name="ano" value="<?php echo $a; ?>">{{ $a }}</option>
							         @endif
							        <?php } ?>
							    </select>
							</td>
						    </tr>
							 <tr>
							   <td> Arquivo: </td>
							   <td> <input class="form-control" type="file" id="file_path" name="file_path" value="" /> </td>
							 </tr>
							</table>
							
							<table>
							 <tr>
							   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="demonstrativoFinanceiro" /> </td>
							   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarDemonstrativoFinanceiro" /> </td>
							   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							 </tr>
							</table>
							
							<table>
							  <tr>
								<td> <a href="{{route('demonstrativoFinanCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a> </td>
								<td> <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> </td>
							  </tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>	
		<div class="col-md-2 col-sm-0"></div>	
    </div>
</div>
@endsection