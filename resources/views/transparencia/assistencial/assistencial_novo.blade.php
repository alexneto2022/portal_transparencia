@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
    <div class="row" style="margin-bottom: 25px; margin-top: 25px;">
        <div class="col-md-12 text-center">
            <h5  style="font-size: 18px;">CADASTRAR RELATÓRIO ASSISTENCIAL:</h5>
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
					<form action="{{\Request::route('storeAssistencial'), $unidade->id}}" method="post">
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
						  <td> <?php $ano = date('Y', strtotime('now')); ?>
							    <select class="form-control" id="ano_ref" name="ano_ref" style="width: 100px;">
							        <?php for($a = 2020; $a <= 2025; $a++) { ?>
							         @if($a == $ano)
							          <option id="ano_ref" name="ano_ref" value="<?php echo $a; ?>" selected>{{ $a }}</option>
							         @else
							          <option id="ano_ref" name="ano_ref" value="<?php echo $a; ?>">{{ $a }}</option>
							         @endif
							        <?php } ?>
							    </select>
						  </td>
						 </tr>
						</table>

						<table class="form-control"> <br />
						 <tr>
						  <td> Descrição: </td>
						  <td> <input type="text" id="descricao" name="descricao" value="" class="form-control" style="width: 300px" required /> </td>
						 </tr>
						 <tr>
						  <td> Meta Controlada/Mês: </td>
					      <td> <input type="text" id="meta" name="meta" value="" class="form-control" style="width: 300px" /> </td>
						 </tr>
						 <tr>
					  	  <td> Janeiro: </td>
						  <td> <input type="text" id="janeiro" name="janeiro" value="" class="form-control" style="width: 300px" /> </td>
						 </tr>
						 <tr>
						  <td> Fevereiro: </td>
						  <td> <input type="text" id="fevereiro" name="fevereiro" value="" class="form-control" style="width: 300px" /> </td>
						 </tr>
						 <tr> 
						  <td> Março: </td>
						  <td> <input type="text" id="marco" name="marco" value="" class="form-control" style="width: 300px" /> </td>
						 </tr>
						 <tr>
						  <td> Abril: </td>
						  <td> <input type="text" id="abril" name="abril" value="" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Maio: </td>
						  <td> <input type="text" id="maio" name="maio" value="" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Junho: </td>
						  <td> <input type="text" id="junho" name="junho" value="" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Julho: </td>
						  <td> <input type="text" id="julho" name="julho" value="" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Agosto: </td>
						  <td> <input type="text" id="agosto" name="agosto" value="" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Setembro: </td>
						  <td> <input type="text" id="setembro" name="setembro" value="" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Outubro: </td>
						  <td> <input type="text" id="outubro" name="outubro" value="" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Novembro: </td>
						  <td> <input type="text" id="novembro" name="novembro" value="" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
						  <td> Dezembro: </td>
						  <td> <input type="text" id="dezembro" name="dezembro" value="" class="form-control" style="width: 300px"  /> </td>
						 </tr>
						 <tr>
							<td colspan="3" align="right"> <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Adicionar" id="Salvar" name="Salvar" />  </td>
						 </tr>
						</table>

					<table class="table table-sm ">

						<thead class="bg-success">

							<tr>
								<th scope="col">Descrição</th>
								<th scope="col">Meta Contratada/Mês</th>
								<th scope="col">Janeiro</th>
								<th scope="col">Fevereiro</th>
								<th scope="col">Março</th>
								<th scope="col">Abril</th>
								<th scope="col">Maio</th>
								<th scope="col">Junho</th>
								<th scope="col">Julho</th>
								<th scope="col">Agosto</th>
								<th scope="col">Setembro</th>
								<th scope="col">Outubro</th>
								<th scope="col">Novembro</th>
								<th scope="col">Dezembro</th>
								<th scope="col">Alterar</th>
							</tr>

						</thead>
					
					@if(!empty($anosRef))						
						@foreach($anosRef as $aRef)

						<tbody>
							<tr>
							  <th> <input type="text" id="desc" name="desc" value="<?php echo $aRef->descricao; ?>" title="<?php echo $aRef->descricao; ?>" class="form-control" style="width: 100px" readonly="true" /></td>
							  <th> <input type="text" id="met" name="met" value="<?php echo $aRef->meta; ?>" title="<?php echo $aRef->meta; ?>" class="form-control" style="width: 100px" readonly="true" /> </td>
							  <th> <input type="text" id="jan" name="jan" value="<?php echo $aRef->janeiro; ?>" title="<?php echo $aRef->janeiro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="fev" name="fev" value="<?php echo $aRef->fevereiro; ?>" title="<?php echo $aRef->fevereiro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="mar" name="mar" value="<?php echo $aRef->marco; ?>" title="<?php echo $aRef->marco; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="abr" name="abr" value="<?php echo $aRef->abril; ?>" title="<?php echo $aRef->abril; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="mai" name="mai" value="<?php echo $aRef->maio; ?>" title="<?php echo $aRef->maio; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="jun" name="jun" value="<?php echo $aRef->junho; ?>" title="<?php echo $aRef->junho; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="jul" name="jul" value="<?php echo $aRef->julho; ?>" title="<?php echo $aRef->julho; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="ago" name="ago" value="<?php echo $aRef->agosto; ?>" title="<?php echo $aRef->agosto; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="set" name="set" value="<?php echo $aRef->setembro; ?>" title="<?php echo $aRef->setembro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="out" name="out" value="<?php echo $aRef->outubro; ?>" title="<?php echo $aRef->outubro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="nov" name="nov" value="<?php echo $aRef->novembro; ?>" title="<?php echo $aRef->novembro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <input type="text" id="dez" name="dez" value="<?php echo $aRef->dezembro; ?>" title="<?php echo $aRef->dezembro; ?>" class="form-control" style="width: 100px" readonly="true" /> </th>
							  <th> <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('assistencialAlterar', array($unidade->id, $aRef->id))}}" > Alterar <i class="fas fa-times-circle"></i></a>  </th>
							</tr>
						</tbody>	

						@endforeach
					@endif
					<table>

						 <tr>
						   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
						   <td> <input hidden type="text" class="form-control" id="tela" name="tela" value="relAssistencial" /> </td>
						   <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarRelAssistencial" /> </td>
						   <td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						 </tr>

						</table>

						<table>
						  <tr>
							<td align="left"> <br />
							 <a href="{{route('assistencialCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						    </td>
						  </tr>
						</table>
					</form>
			</div>
        </div>
		<div class="col-md-1 col-sm-0"></div>
    </div>
</div>
@endsection