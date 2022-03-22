@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
    <div class="row" style="margin-bottom: 25px; margin-top: 25px;">
        <div class="col-md-12 text-center">
            <h5  style="font-size: 18px;">ALTERAR RELATÓRIO ASSISTENCIAL:</h5>
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
		<div class="col-md-20 col-sm-18 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						RELATÓRIO ASSISTENCIAL: <i class="fas fa-check-circle"></i>
					</a>				
				</div>
					<form action="{{\Request::route('update'), $unidade->id}}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
						
						<table class="form-control"> <br />
						 <tr>
						  <td> Indicador: </td>
						  <td> &nbsp; </td>
						  <td>
						  <select id="indicador_id" name="indicador_id" class="form-control" onchange="exibir_ocultar(this)"> 
								<option value="1"> 1. Consultas Médicas </option> 
								<option value="2"> 2. Comissão de Controle </option> 
							  </select>
                          </td>
					      <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
					  	  <td> Ano de Referência: </td>
						  <td> &nbsp; </td>
						  <td> <input type="number" id="ano_ref" name="ano_ref" value="<?php if(!empty($anosRef)){ echo $anosRef[0]->ano_ref; }else { echo ""; } ?>" class="form-control" style="width: 100px" required /> </td>
						 </tr>
						</table>

						<table class="form-control"> <br />
						 <tr>
						  <td> Descrição: </td>
						  <td> <input type="text" id="descricao" name="descricao" value="<?php if(!empty($anosRef)){ echo $anosRef[0]->descricao; }else { echo ""; } ?>" class="form-control" style="width: 300px" required /> </td>
						 </tr>
						 <tr>
						  <td> Meta Controlada/Mês: </td>
					      <td> <input type="text" id="meta" name="meta" value="<?php if(!empty($anosRef)){ echo $anosRef[0]->meta; }else { echo ""; } ?>" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
					  	  <td> Janeiro: </td>
						  <td> <input type="text" id="janeiro" name="janeiro" value="<?php if(!empty($anosRef)){ echo $anosRef[0]->janeiro;}else { echo ""; } ?>" class="form-control" style="width: 300px" /> </td>
						 </tr>
						 <tr>
						  <td> Fevereiro: </td>
						  <td> <input type="text" id="fevereiro" name="fevereiro" value="<?php if(!empty($anosRef)){ echo $anosRef[0]->fevereiro; }else { echo ""; } ?>" class="form-control" style="width: 300px" /> </td>
						 </tr>
						 <tr> 
						  <td> Março: </td>
						  <td> <input type="text" id="marco" name="marco" value="<?php if(!empty($anosRef)){ echo $anosRef[0]->marco; }else { echo ""; } ?>" class="form-control" style="width: 300px" /> </td>
						 </tr>
						 <tr>
						  <td> Abril: </td>
						  <td> <input type="text" id="abril" name="abril" value="<?php if(!empty($anosRef)){ echo $anosRef[0]->abril; }else { echo ""; } ?>" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Maio: </td>
						  <td> <input type="text" id="maio" name="maio" value="<?php if(!empty($anosRef)){ echo $anosRef[0]->maio; }else { echo ""; } ?>" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Junho: </td>
						  <td> <input type="text" id="junho" name="junho" value="<?php if(!empty($anosRef)){ echo $anosRef[0]->junho; }else { echo ""; } ?>" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Julho: </td>
						  <td> <input type="text" id="julho" name="julho" value="<?php if(!empty($anosRef)){ echo $anosRef[0]->julho; }else { echo ""; } ?>" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Agosto: </td>
						  <td> <input type="text" id="agosto" name="agosto" value="<?php if(!empty($anosRef)){ echo $anosRef[0]->agosto; }else { echo ""; } ?>" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Setembro: </td>
						  <td> <input type="text" id="setembro" name="setembro" value="<?php if(!empty($anosRef)){ echo $anosRef[0]->setembro; }else { echo ""; } ?>" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Outubro: </td>
						  <td> <input type="text" id="outubro" name="outubro" value="<?php if(!empty($anosRef)){ echo $anosRef[0]->outubro; }else { echo ""; } ?>" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Novembro: </td>
						  <td> <input type="text" id="novembro" name="novembro" value="<?php if(!empty($anosRef)){ echo $anosRef[0]->novembro; }else { echo ""; } ?>" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Dezembro: </td>
						  <td> <input type="text" id="dezembro" name="dezembro" value="<?php if(!empty($anosRef)){ echo $anosRef[0]->dezembro; }else { echo ""; } ?>" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 </table>

				
						 <tr>
						   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
						   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="relAssistencial" /> </td>
						   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarRelAssistencial" /> </td>
						   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						 </tr>

						</table>

						<table>
						  <tr>
							<td align="left"> <br>
							 <a href="{{route('assistencialCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							 &nbsp;&nbsp;<input type="submit" class="btn btn-success btn-sm" value="Alterar" id="Salvar" name="Salvar" />
						    </td> <br>
						  </tr>
						</table>
					</form>
			</div>
        </div>
		<div class="col-md-1 col-sm-0"></div>
    </div>
</div>
@endsection