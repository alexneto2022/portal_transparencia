@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" style="margin-top: 25px;">
	<div class="row" style="margin-bottom: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">EXCLUIR DECRETO DE QUALIFICAÇÃO:</h5>
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
                        Decreto de Qualificação <i class="fas fa-check-circle"></i>
                    </a>
				</div> 
				    <form action="{{\Request::route('store'), $unidade->id}}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					  <table border="0" class="table-sm" style="line-height: 1.5;" WIDTH="1020">
						<tr>
						 <td> Título: </td>
						 <td> <input style="width: 500px" class="form-control" type="text" id="title" name="title" value="<?php echo $decretos[0]->title; ?>" readonly="true" /> </td>
						</tr>
						<tr>
						 <td> Número do Decreto: </td>
						 <td> <input style="width: 200px" class="form-control" type="text" id="decreto" name="decreto" value="<?php echo $decretos[0]->decreto; ?>" readonly="true" /> </td>
						</tr>
						<tr>
						  <td> Tipo: </td>
						  <td> <input name="kind" id="kind" type="text" readonly="true" class="form-control" style="width: 200px" value="<?php echo $decretos[0]->kind; ?>" /> </td>
						</tr>
						<tr>
					     <td> Arquivo: </td>
						 <td> <input style="width: 450px" class="form-control" type="text" id="path_file" name="path_file" value="<?php echo $decretos[0]->path_file; ?>" readonly="true" /> </td>
						</tr>
					  </table>	
						
					  <table>
						   <tr>
						     <td> <input type="hidden" id="unidade_id" name="unidade_id" value="1" /> </td>
							 <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="decretos" /> </td>
							 <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="excluirDecretos" /> </td>
							 <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						   </tr>
						</table>
						
					 <table>
						<tr>
						  <td align="left"> <br />
						  <p><h6 align="left"> Deseja realmente Excluir este Decreto de Qualificação?? </h6></p>
							 <a href="{{route('decretoCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							 <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Excluir" id="Excluir" name="Excluir" />
						  </td>
						</tr>
					</table>
				  </form>
				</div>	
        </div>
    </div>
</div>
@endsection