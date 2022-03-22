@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">EXCLUIR DEMONSTRATIVOS FINANCEIROS:</h3>
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
			<form action="{{\Request::route('destroy'), $unidade->id}}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<table> 
				 <tr>
				   <td> Título: </td>
				   <td> <input style="width: 300px;" class="form-control" readonly="true" type="text" id="title" name="title" value="<?php echo $financialReports[0]->title; ?>" /> </td>
				 </tr>
				 <tr>
				   <td> Mês: </td>
				   <td> <input style="width: 100px;" readonly="true" class="form-control" type="number" id="mes" name="mes" value="<?php echo $financialReports[0]->mes; ?>" maxlength="12" size="2" /> </td>
				 </tr>
				 <tr>
				   <td> Ano: </td>
				   <td> <input style="width: 100px;" readonly="true" class="form-control" type="number" id="ano" name="ano" value="<?php echo $financialReports[0]->ano; ?>" /> </td>
				 </tr>
				 <tr>
				   <td> Arquivo: </td>
				   <td> <input style="width: 700px;" class="form-control" readonly="true" type="text" id="file_path" name="file_path" value="<?php echo $financialReports[0]->file_path; ?>" /> </td>
				 </tr>
				</table>
				
				<table>
				 <tr>
				   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
				   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="demonstrativoFinanceiro" /> </td>
				   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="excluirDemonstrativoFinanceiro" /> </td>
				   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
				 </tr>
				</table>
				
				<table>
				  <tr>
				   <td> <br /> <br /> <p><h6 align="left"> Deseja realmente Excluir este Demonstrativo Financeiro?? </h6></p> </td>
				  </tr>
				  <tr>
					<td colspan="2"> <a href="{{route('demonstrativoFinanCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a> 
					<input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir" id="Salvar" name="Salvar" /> </td>
				  </tr>
				</table>
			</form>
        </div>
		<div class="col-md-2 col-sm-0"></div> 
    </div>
</div>
@endsection